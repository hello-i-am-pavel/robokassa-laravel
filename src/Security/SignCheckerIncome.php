<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Security;

use Hiap\Robokassa\Config\Config;
use Illuminate\Http\Request;

/**
 * Для проверок использует password2
 *
 * Class SignChecker
 * @package App\Util
 */
readonly class SignCheckerIncome
{
    /**
     * @param Config $config
     */
    public function __construct(
        protected Config $config
    ) {
    }

    /**
     * @param string $signatureValue
     * @param string $invId
     * @param string $outSum
     * @param array $customFields
     * @return bool
     */
    public function checkSign(
        string $signatureValue,
        string $invId,
        string $outSum,
        array $customFields = []
    ): bool {
        $hashGenerated = $this->buildHash($invId, $outSum, $customFields);

        return strtolower($signatureValue) === strtolower($hashGenerated);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function checkRequestSignature(Request $request): bool
    {
        return $this->checkSign(
            $request->get('SignatureValue'),
            $request->get('InvId'),
            $request->get('OutSum'),
        );
    }

    /**
     * @param string $invId
     * @param string $outSum
     * @param array $customFields
     * @return string
     */
    public function buildHash(
        string $invId,
        string $outSum,
        array $customFields = []
    ): string {
        $customVars = $this->getCustomValues($customFields);

        return md5("{$outSum}:{$invId}:{$this->getPasswordForHash()}{$customVars}");
    }

    /**
     * @return string
     */
    protected function getPasswordForHash(): string
    {
        return $this->config->getPassword2();
    }

    /**
     * Получение строки с пользовательскими данными для шифрования
     *
     * @return string
     */
    private function getCustomValues(array $customFields): string
    {
        $out = '';
        $customVars = array();
        if (empty($customFields)) {
            return $out;
        }

        foreach ($customFields as $k => $v) {
            $customVars[$k] = $k . '=' . $v;
        }

        sort($customVars);

        return ':' . implode(':', $customVars);
    }
}
