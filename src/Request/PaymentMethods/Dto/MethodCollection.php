<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\PaymentMethods\Dto;

use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Class MethodCollection
 */
class MethodCollection extends Collection
{
    /**
     * Create a new collection.
     *
     * @return void
     */
    public function __construct($items = [])
    {
        foreach ($items as $item) {
            if (!($item instanceof Method)) {
                throw new InvalidArgumentException('Collection must contain only ' . Method::class);
            }
        }

        parent::__construct($items);
    }
}
