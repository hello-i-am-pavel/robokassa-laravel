<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Factory;

use Hiap\Robokassa\Config\Config;
use Hiap\Robokassa\Config\TestConfig;
use Hiap\Robokassa\Enum\HashType;
use Hiap\Robokassa\Robokassa;

/**
 * Class RobokassaFactory
 * @package Hiap\Robokassa\Factory
 */
class RobokassaFactory
{
    /**
     * @return Robokassa
     */
    public static function build(): Robokassa
    {
        $isTest = config('robokassa.is_test') ?? false;

        $configClass = $isTest
            ? TestConfig::class
            : Config::class;

        $hashType = config('robokassa.hash_type');

        return new Robokassa(
            new $configClass(
                config('robokassa.shop_id'),
                config('robokassa.password1'),
                config('robokassa.password2'),
                $hashType === null
                    ? HashType::MD5
                    : HashType::from($hashType)
            )
        );
    }
}
