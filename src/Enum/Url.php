<?php

declare(strict_types=1);

namespace Hiap\Robokassa\Enum;

/**
 * Class Url
 * @package App\Util\Enum
 */
enum Url: string
{
    case PAYMENT_URL = 'https://auth.robokassa.ru/Merchant/Index.aspx';

    case PAYMENT_CURL = 'https://auth.robokassa.ru/Merchant/Indexjson.aspx';

    case RECURRENT_URL = 'https://auth.robokassa.ru/Merchant/Recurring';

    case WEB_SERVICE_URL = 'https://auth.robokassa.ru/Merchant/WebService/Service.asmx';
}
