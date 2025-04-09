<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Dto;

use Hiap\Robokassa\Enum\PaymentMethod;

/**
 * Class Item
 * @package App\Util\Request\Merchant\Dto
 */
readonly class Item
{
    /**
     * @param string $name
     * @param int $quantity
     * @param int $sum
     * @param string $paymentMethod
     * @param string $payment_object
     * @param string $tax
     */
    public function __construct(
        private string $name = 'Product name',
        private int $quantity = 1,
        private int $sum = 100,
        private PaymentMethod $paymentMethod = PaymentMethod::FULL_PAYMENT,
        private string $payment_object = 'commodity',
        private string $tax = 'none'
    ) {
    }

    /**
     * @return string
     */
    public function getPaymentObject(): string
    {
        return $this->payment_object;
    }

    /**
     * @return string
     */
    public function getPaymentMethod(): string
    {
        return $this->paymentMethod->value;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getTax(): string
    {
        return $this->tax;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSum(): int
    {
        return $this->sum;
    }
}
