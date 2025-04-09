<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\OpState\Dto;

/**
 * Class Info
 * @package Hiap\Robokassa\Request\OpState\Dto
 */
readonly class Info
{
    /**
     * @param string $incCurrLabel
     * @param int $incSum
     * @param string $incAccount
     * @param PaymentMethod $paymentMethod
     * @param string $outCurrLabel
     * @param int $outSum
     */
    public function __construct(
        public string $incCurrLabel,
        public int $incSum,
        public string $incAccount,
        public PaymentMethod $paymentMethod,
        public string $outCurrLabel,
        public int $outSum
    ) {
    }
}
