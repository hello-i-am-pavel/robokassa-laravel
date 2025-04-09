<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Dto;

use JsonException;

/**
 * Class Receipt
 * @package App\Util\Request\Merchant\Dto
 */
class Receipt
{
    private array $items = [];

    /**
     * @param Item $item
     * @return $this
     */
    public function addItem(Item $item): static
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->items as $item) {
            $result[] = [
                'name' => $item->getName(),
                'quantity' => $item->getQuantity(),
                'sum' => $item->getSum(),
                'payment_method' => $item->getPaymentMethod(),
                'payment_object' => $item->getPaymentObject(),
                'tax' => $item->getTax(),
            ];
        }

        return $result;
    }

    /**
     * @return string
     * @throws JsonException
     */
    public function toJson(): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR);
    }
}
