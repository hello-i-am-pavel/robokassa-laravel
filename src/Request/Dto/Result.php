<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\Dto;

use Hiap\Robokassa\Enum\ResultCode;

/**
 * Class Result
 * @package Hiap\Robokassa\Request\Dto
 */
readonly class Result
{
    /**
     * @param ResultCode $code
     * @param string|null $description
     */
    public function __construct(
        public ResultCode $code,
        public ?string $description = null,
    )
    {
    }
}
