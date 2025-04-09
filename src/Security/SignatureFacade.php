<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Security;

use Hiap\Robokassa\Config\Config;

/**
 * Class SignatureFacade
 * @package App\Util
 */
readonly class SignatureFacade
{
    /**
     * Для проверок использует password1
     *
     * @var SingCheckerOutcome
     */
    public SingCheckerOutcome $outcome;

    /**
     * Для проверок использует password2
     *
     * @var SignCheckerIncome
     */
    public SignCheckerIncome $income;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->income = new SignCheckerIncome($config);
        $this->outcome = new SingCheckerOutcome($config);
    }
}
