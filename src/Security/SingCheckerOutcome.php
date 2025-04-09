<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Security;

/**
 *  Для проверок использует password1
 *
 * Class SingCheckerOutcome
 * @package App\Util
 */
readonly class SingCheckerOutcome extends SignCheckerIncome
{
    /**
     * @return string
     */
    protected function getPasswordForHash(): string
    {
        return $this->config->getPassword1();
    }
}
