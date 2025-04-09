<?php

return [
    'is_test' => env('ROBOKASSA_TEST', false),

    'shop_id' => env('ROBOKASSA_SHOP_ID'),

    'password1' => env('ROBOKASSA_PASSWORD_1'),

    'password2' => env('ROBOKASSA_PASSWORD_2'),

    'hash_type' => env('ROBOKASSA_HASH_TYPE', 'md5'),
];
