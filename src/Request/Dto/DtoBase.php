<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Dto;

use ReflectionClass;
use ReflectionProperty;

/**
 * Class DtoBase
 * @package Hiap\Robokassa\Request\Dto
 */
abstract class DtoBase
{
    /**
     * @return array
     */
    public function getFields(): array
    {
        $reflect = new ReflectionClass($this);
        $properties = $reflect->getProperties(ReflectionProperty::IS_PUBLIC);

        return array_map(function (ReflectionProperty $property) {
            return $property->getValue($this);
        }, $properties);
    }
}
