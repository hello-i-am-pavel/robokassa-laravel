<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\OpState;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Hiap\Robokassa\Config\TestConfig;
use Hiap\Robokassa\Enum\OpStateCode;
use Hiap\Robokassa\Enum\ResultCode;
use Hiap\Robokassa\Request\Dto\Result;
use Hiap\Robokassa\Request\OpState\Dto\Info;
use Hiap\Robokassa\Request\OpState\Dto\OpStateResponseDto;
use Hiap\Robokassa\Request\OpState\Dto\PaymentMethod;
use Hiap\Robokassa\Request\OpState\Dto\State;
use Hiap\Robokassa\Request\Trait\RequestTrait;
use Illuminate\Support\Arr;
use JsonException;

/**
 * Получение состояния оплаты счета
 *
 *  Возвращает детальную информацию о текущем состоянии и реквизитах оплаты.
 *  Необходимо помнить, что операция инициируется не в момент ухода пользователя на оплату,
 *  а позже – после подтверждения его платежных реквизитов,
 *  т.е. Вы вполне можете не находить операцию, которая по Вашему мнению уже должна начаться.
 *
 * Class OpStateRequest
 * @package App\Util
 */
class OpStateRequest
{
    use RequestTrait;

    public const SEGMENT = 'OpState';

    /**
     * @param int $invoiceId
     * @return array
     * @throws GuzzleException
     * @throws JsonException
     */
    public function opState(int $invoiceId): OpStateResponseDto
    {
        $params = [
            'MerchantLogin' => $this->config->getLogin(),
            'InvoiceID' => $invoiceId,
            'Signature' => $this->signatureState($invoiceId)
        ];

        if ($this->config instanceof TestConfig) {
            $params['IsTest'] = '1';
        }

        $query = http_build_query($params);
        $url = $this->getWebServiceUrl(self::SEGMENT, $query);

        $result = $this->getRequest($url);

        return new OpStateResponseDto(
            new Result(
                ResultCode::from($result['Result']['Code']),
                Arr::get($result, 'Result.Description'),
            ),
            $this->getState($result),
            $this->getInfo($result),
            Arr::get($result, 'UserFields'),
        );
    }

    /**
     * @param array $result
     * @return State|null
     */
    private function getState(array $result): ?State
    {
        $state = Arr::get($result, 'State');
        if (empty($state)) {
            return null;
        }

        return new State(
            OpStateCode::from($state['Code']),
            Carbon::make(Arr::get($state, 'RequestDate')),
            Carbon::make(Arr::get($state, 'StateDate')),
        );
    }

    /**
     * @param array $result
     * @return Info|null
     */
    private function getInfo(array $result): ?Info
    {
        $info = Arr::get($result, 'Info');
        if (empty($info)) {
            return null;
        }

        return new Info(
            Arr::get($info, 'IncCurrLabel'),
            Arr::get($info, 'IncSum'),
            Arr::get($info, 'IncAccount'),
            new PaymentMethod(
                Arr::get($info, 'PaymentMethod.Code'),
                Arr::get($info, 'PaymentMethod.Description'),
            ),
            Arr::get($info, 'OutCurrLabel'),
            Arr::get($info, 'OutSum'),
        );
    }

    /**
     * Подпись для запроса проверки статуса счета
     *
     * @param $invoiceID
     * @return string
     */
    private function signatureState($invoiceID): string
    {
        return hash(
            $this->config->getHashType()->value,
            "{$this->config->getLogin()}:$invoiceID:{$this->config->getPassword2()}"
        );
    }
}
