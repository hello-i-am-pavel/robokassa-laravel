<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Enum;

/**
 * Enum ResultCode
 * @package Hiap\Robokassa\Enum
 */
enum ResultCode: int
{
    /**
     * Запрос обработан успешно
     */
    case SUCCESS = 0;

    /**
     * Неверная цифровая подпись запроса
     */
    case INVALID_DIGITAL_SIGNATURE = 1;

    /**
     * Информация о магазине с таким MerchantLogin не найдена или магазин не активирован
     */
    case MERCHANT_NOT_FOUND = 2;

    /**
     * Информация об операции с таким InvoiceID не найдена.
     */
    case OPERATION_NOT_FOUND = 3;

    /**
     * Найдено две операции с таким InvoiceID. Такая ошибка возникает когда есть тестовая оплата с тем же InvoiceID.
     */
    case TWO_OPERATIONS_FOUND = 4;

    /**
     * Внутренняя ошибка сервиса
     */
    case INTERNAL_ERROR = 1000;
}
