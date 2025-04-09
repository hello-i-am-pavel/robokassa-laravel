<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Request\PaymentMethods;

use GuzzleHttp\Exception\GuzzleException;
use Hiap\Robokassa\Enum\Language;
use Hiap\Robokassa\Enum\ResultCode;
use Hiap\Robokassa\Request\Dto\Result;
use Hiap\Robokassa\Request\PaymentMethods\Dto\Method;
use Hiap\Robokassa\Request\PaymentMethods\Dto\MethodCollection;
use Hiap\Robokassa\Request\PaymentMethods\Dto\PaymentMethodsResponseDto;
use Hiap\Robokassa\Request\Trait\RequestTrait;
use Illuminate\Support\Arr;
use JsonException;

/**
 * Получение списка доступных способов оплаты
 *
 * Возвращает список способов оплаты, доступных для оплаты заказов указанного магазина/сайта.
 *
 * Class PaymentMethodsRequest
 * @package App\Util
 */
class PaymentMethodsRequest
{
    use RequestTrait;

    public const SEGMENT = 'GetPaymentMethods';

    /**
     * @param Language $lang
     *
     * @return PaymentMethodsResponseDto
     *
     * @throws GuzzleException
     * @throws JsonException
     */
    public function getPaymentMethods(Language $lang = Language::EN): PaymentMethodsResponseDto
    {
        $query = http_build_query([
            'MerchantLogin' => $this->config->getLogin(),
            'Language' => $lang->value,
        ]);

        $url = $this->getWebServiceUrl(self::SEGMENT, $query);
        $result = $this->getRequest($url);


        return new PaymentMethodsResponseDto(
            new Result(
                ResultCode::from(Arr::get($result, 'Result.Code')),
            ),
            $this->getMethodCollection($result)
        );
    }

    /**
     * @param array $result
     * @return MethodCollection
     */
    private function getMethodCollection(array $result): MethodCollection
    {
        $collection = new MethodCollection();

        foreach (Arr::get($result, 'Methods', []) as $method) {
            foreach ($method as $item) {
                // Костыль полный позитива
                if ($attributes = Arr::get($item, '@attributes')) {
                    $item = $attributes;
                }

                $collection->add(
                    new Method(
                        Arr::get($item, 'Code'),
                        Arr::get($item, 'Description')
                    )
                );
            }
        }

        return $collection;
    }
}
