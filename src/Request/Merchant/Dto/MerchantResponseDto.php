<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Merchant\Dto;

/**
 * Class MerchantResponseDto
 * @package App\Util\Request\Merchant\Dto
 */
readonly class MerchantResponseDto
{
    /**
     * @param string $paymentUrl
     */
    public function __construct(
        public string $paymentUrl
    )
    {
    }

    /**
     * @return string
     */
    public function getPaymentUrl(): string
    {
        return $this->paymentUrl;
    }
}
