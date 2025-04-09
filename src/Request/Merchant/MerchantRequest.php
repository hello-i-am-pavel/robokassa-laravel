<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Merchant;

use Hiap\Robokassa\Config\Config;
use Hiap\Robokassa\Config\TestConfig;
use Hiap\Robokassa\Enum\Url;
use Hiap\Robokassa\Request\Merchant\Dto\MerchantRequestDto;
use Hiap\Robokassa\Request\Merchant\Dto\MerchantResponseDto;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;
use RuntimeException;

/**
 * Class MerchantRequest
 * @package App\Util
 */
readonly class MerchantRequest
{
    /**
     * @param Config $config
     * @param Client $httpClient
     */
    public function __construct(
        private Config $config,
        private Client $httpClient,
    ) {
    }

    /**
     * Send payment request via CURL
     *
     * @param MerchantRequestDto $requestDto
     * @return MerchantResponseDto
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendMerchantRequest(MerchantRequestDto $requestDto): MerchantResponseDto
    {
        $params['OutSum'] = $requestDto->getOutSum();
        $params['Description'] = $requestDto->getDescription();
        $params['MerchantLogin'] = $this->config->getLogin();
        $params['Receipt'] = $requestDto->getReceipt()?->toArray() ?? [];

        if ($this->config instanceof TestConfig) {
            $params['IsTest'] = '1';
        }

        $signatureParams = [
            'OutSum' => $params['OutSum'],
            'InvoiceID' => $params['InvoiceID'] ?? '',
        ];

        if (!empty($params['Receipt'])) {
            $signatureParams['Receipt'] = urlencode(json_encode($params['Receipt'], JSON_THROW_ON_ERROR));
            $params['Receipt'] = urlencode($signatureParams['Receipt']);
        }

        $fields = $this->getFields($params);

        if (!empty($fields)) {
            $signatureParams = array_merge($signatureParams, $fields);

            foreach ($fields as $name => $value) {
                $params[$name] = urlencode($value);
            }
        }

        $params['SignatureValue'] = $this->generateSignature($signatureParams);

        try {
            $response = $this->httpClient->post(Url::PAYMENT_CURL->value, [
                'form_params' => $params,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new RuntimeException(
                    'Failed to send payment request. HTTP Status: ' . $response->getStatusCode()
                );
            }

            $responseData = json_decode(
                $response->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );

            if (empty($responseData['invoiceID'])) {
                throw new RuntimeException('Invoice ID not found in response.');
            }

            return new MerchantResponseDto(
                'https://auth.robokassa.ru/Merchant/Index/' . $responseData['invoiceID']
            );
        } catch (RuntimeException $e) {
            throw new RuntimeException('CURL request failed: ' . $e->getMessage());
        }
    }

    /**
     * @param $params
     * @return array
     */
    private function getFields($params): array
    {
        $fields = [];

        foreach ($params as $key => $value) {
            if (!preg_match('~^Shp_~iu', $key)) {
                continue;
            }

            $fields[$key] = urlencode($value);
        }

        ksort($fields);

        return $fields;
    }

    /**
     * Подпись для запроса оплаты
     *
     * @param $params
     * @return string
     */
    private function generateSignature($params): string
    {
        $required = [
            $this->config->getLogin(),
            $params['OutSum'],
            $params['InvoiceID'],
        ];

        if (!empty($params['Receipt'])) {
            $required[] = $params['Receipt'];
        }

        $required[] = $this->config->getPassword1();

        $hash = $this->getHashFields($params, $required);

        return hash($this->config->getHashType()->value, $hash);
    }

    /**
     * @param $params
     * @param $required
     * @return string
     */
    private function getHashFields($params, $required): string
    {
        $fields = [];

        foreach ($params as $key => $value) {
            if (0 !== stripos($key, 'Shp_')) {
                continue;
            }

            $required[] = $key . '=' . $value;
        }

        $hash = implode(':', $required);

        if (!empty($fields)) {
            $hash .= ':' . implode(':', $fields);
        }

        return $hash;
    }
}
