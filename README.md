![Robokassa](.github/icon-logo-white.svg)

# Robokassa PHP SDK for Laravel

## Install

```

composer require hello-i-am-pavel/robokassa-laravel

```
Define robokassa credentials.
Add to <b>.env</b>

```
ROBOKASSA_TEST=false
ROBOKASSA_SHOP_ID=your_shop_id
ROBOKASSA_PASSWORD_1=topsecretpass1
ROBOKASSA_PASSWORD_2=topsecretpass2
```

Publish config

```shell
php artisan vendor:publish --provider "Hiap\Robokassa\ServiceProvider\RobokassaServiceProvider"
```

Simple merchant request

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

You can check use DI and check income sign

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
