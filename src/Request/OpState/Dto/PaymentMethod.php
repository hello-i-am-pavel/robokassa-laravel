<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\OpState\Dto;

/**
 * Class PaymentMethod
 * @package Hiap\Robokassa\Request\OpState\Dto
 */
readonly class PaymentMethod
{
    /**
     * @param string $code
     * @param string $description
     */
    public function __construct(
        public string $code,
        public string $description
    )
    {

    }
}
