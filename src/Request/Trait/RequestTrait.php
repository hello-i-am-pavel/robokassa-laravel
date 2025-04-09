<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Trait;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Hiap\Robokassa\Config\Config;
use Hiap\Robokassa\Enum\Url;
use JsonException;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Trait RequestTrait
 * @package App\Util\Trait
 */
trait RequestTrait
{
    /**
     * @param Client $httpClient
     * @param Config $config
     */
    public function __construct(
        private readonly Config $config,
        private readonly Client $httpClient,
    ) {
    }

    /**
     * @param $segment
     * @param $query
     * @return string
     */
    private function getWebServiceUrl($segment, $query): string
    {
        return sprintf(
            '%s/%s?%s',
            Url::WEB_SERVICE_URL->value,
            $segment,
            $query
        );
    }

    /**
     * @param string $url
     * @return array
     * @throws GuzzleException
     * @throws RuntimeException
     * @throws JsonException
     */
    private function getRequest(string $url): array
    {
        try {
            $response = $this->httpClient->get($url);

            if ($response->getStatusCode() !== 200) {
                throw new RuntimeException('Ошибка запроса: HTTP ' . $response->getStatusCode());
            }

            return $this->responseToArray($response);
        } catch (RuntimeException $e) {
            throw new RuntimeException('Ошибка запроса: ' . $e->getMessage());
        }
    }


    /**
     * @param ResponseInterface $response
     * @return array
     * @throws JsonException
     */
    private function responseToArray(ResponseInterface $response): array
    {
        $xml = $response->getBody()->getContents();

        $encodedJson = json_encode(
            (array)simplexml_load_string($xml),
            JSON_THROW_ON_ERROR | JSON_NUMERIC_CHECK
        );

        return json_decode(
            $encodedJson,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}

