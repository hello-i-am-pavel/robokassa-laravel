<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\PaymentMethods\Dto;

/**
 * Class Method
 * @package Hiap\Robokassa\Request\PaymentMethods\Dto
 */
class Method
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
