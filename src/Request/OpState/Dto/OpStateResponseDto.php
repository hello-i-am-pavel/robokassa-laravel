<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\OpState\Dto;

use Hiap\Robokassa\Request\Dto\Result;

/**
 * Class OpStateResponseDto
 * @package Hiap\Robokassa\Request\OpState\Dto
 */
readonly class OpStateResponseDto
{
    /**
     * @param Result $result
     * @param array|null $state
     * @param array|null $info
     * @param array|null $userFields
     */
    public function __construct(
        public Result $result,
        public ?State $state,
        public ?Info $info,
        public ?array $userFields
    )
    {
    }
}
