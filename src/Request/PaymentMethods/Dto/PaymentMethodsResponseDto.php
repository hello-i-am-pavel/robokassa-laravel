<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\PaymentMethods\Dto;

use Hiap\Robokassa\Request\Dto\Result;

/**
 * Class PaymentMethodsResponseDto
 * @package Hiap\Robokassa\Request\PaymentMethods\Dto
 */
readonly class PaymentMethodsResponseDto
{
    /**
     * @param Result $result
     * @param MethodCollection $methods
     */
    public function __construct(
        public Result $result,
        public MethodCollection $methods
    ) {
    }
}
