<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request;

use Hiap\Robokassa\Config\Config;
use Hiap\Robokassa\Enum\Language;
use Hiap\Robokassa\Request\Merchant\Dto\MerchantRequestDto;
use Hiap\Robokassa\Request\Merchant\Dto\MerchantResponseDto;
use Hiap\Robokassa\Request\Merchant\MerchantRequest;
use Hiap\Robokassa\Request\OpState\Dto\OpStateResponseDto;
use Hiap\Robokassa\Request\OpState\OpStateRequest;
use Hiap\Robokassa\Request\PaymentMethods\Dto\PaymentMethodsResponseDto;
use Hiap\Robokassa\Request\PaymentMethods\PaymentMethodsRequest;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use JsonException;

/**
 * Class RequestFacade
 * @package App\Util\Request
 */
readonly class RequestFacade
{
    /**
     * @param Config $config
     * @param Client $client
     */
    public function __construct(
        private Config $config,
        private Client $client,
    ) {
    }

    /**
     * @param MerchantRequestDto $requestDto
     * @return MerchantResponseDto
     * @throws GuzzleException
     * @throws JsonException
     */
    public function sendMerchantRequest(MerchantRequestDto $requestDto): MerchantResponseDto
    {
        return (new MerchantRequest(
            $this->config,
            $this->client
        ))->sendMerchantRequest($requestDto);
    }

    /**
     * @param Language $lang
     * @return PaymentMethodsResponseDto
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getPaymentMethods(Language $lang = Language::EN): PaymentMethodsResponseDto
    {
        return (new PaymentMethodsRequest(
            $this->config,
            $this->client,
        ))->getPaymentMethods($lang);
    }

    /**
     * @param int $invoiceId
     * @return OpStateResponseDto
     * @throws GuzzleException
     * @throws JsonException
     */
    public function opState(int $invoiceId): OpStateResponseDto
    {
        return (new OpStateRequest(
            $this->config,
            $this->client
        ))->opState($invoiceId);
    }
}
