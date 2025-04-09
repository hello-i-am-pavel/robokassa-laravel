<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\OpState\Dto;

use Carbon\Carbon;
use Hiap\Robokassa\Enum\OpStateCode;

/**
 * Class State
 * @package Hiap\Robokassa\Request\OpState\Dto
 */
readonly class State
{
    /**
     * @param OpStateCode $code
     * @param Carbon $requestDate
     * @param Carbon $stateDate
     */
    public function __construct(
        public OpStateCode $code,
        public Carbon $requestDate,
        public Carbon $stateDate
    )
    {
    }
}
