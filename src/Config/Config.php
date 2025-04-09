<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Config;

use Hiap\Robokassa\Enum\HashType;

/**
 * Class Config
 * @package App\Util
 */
readonly class Config
{
    /**
     * @param string $login
     * @param string $password1
     * @param string $password2
     * @param HashType $hashType
     */
    public function __construct(
        protected string $login,
        protected string $password1,
        protected string $password2,
        protected HashType $hashType = HashType::MD5
    ) {
    }

    /**
     * @return HashType
     */
    public function getHashType(): HashType
    {
        return $this->hashType;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPassword1(): string
    {
        return $this->password1;
    }

    /**
     * @return string
     */
    public function getPassword2(): string
    {
        return $this->password2;
    }
}
