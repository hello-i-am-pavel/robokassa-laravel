![Robokassa](.github/icon-logo-white.svg)

# Robokassa SDK (PHP + Laravel) 

SDK для интеграции с платежной системой **Robokassa** в PHP с использованием Laravel.  
Позволяет отправлять платежные запросы, получать статус оплаты и список доступных методов оплаты.

## 📦 Установка

```

composer require hello-i-am-pavel/robokassa-laravel

```

Добавьте авторизационные данные в `.env`

```
ROBOKASSA_TEST=false
ROBOKASSA_SHOP_ID=your_shop_id
ROBOKASSA_PASSWORD_1=topsecretpass1
ROBOKASSA_PASSWORD_2=topsecretpass2
```

Экспорт конфигурационных файлов

```shell
php artisan vendor:publish --provider "Hiap\Robokassa\ServiceProvider\RobokassaServiceProvider"
```

## 🚀 Использование

Вы можете использовать класс Robokassa в любом месте вашего приложения, например, в контроллере

Пример проверки подписи входящего запроса:

```php
<?php

namespace App\Http\Controllers\Api\v1\Subscription;

use App\Http\Controllers\Controller;
use Hiap\Robokassa\Robokassa;
use Illuminate\Http\Request;

class SomeController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request, Robokassa $robokassa): JsonResponse
    {
        $isSignCorrect = $robokassa->signature->income->checkRequestSignature($request);
        
        return response()->json([
            'success' => $isSignCorrect
        ]);
    }
}
```

Отправка платежного запроса:

```php
use \Hiap\Robokassa\Factory\RobokassaFactory;
use \Hiap\Robokassa\Request\Merchant\Dto\MerchantRequestDto;

$robokassa = RobokassaFactory::build();
$response = $robokassa->request->sendMerchantRequest(new MerchantRequestDto(
    300,
    'my product'
))

dump($response);

```
Проверка статуса:

```php
use \Hiap\Robokassa\Factory\RobokassaFactory;

$robokassa = RobokassaFactory::build();
$response = $robokassa->request->opState(123456);

dump($response);
```

Получение доступных методов оплаты:

```php
use \Hiap\Robokassa\Factory\RobokassaFactory;

$robokassa = RobokassaFactory::build();
$response = $robokassa->request->getPaymentMethods();

dump($response);
```

## 📌 Дополнительно
- SDK активно развивается, в будущем **будут добавлены новые методы**.
- Официальная документация Robokassa: [https://docs.robokassa.ru/](https://docs.robokassa.ru/).
