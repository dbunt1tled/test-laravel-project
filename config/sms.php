<?php

return[

    'driver' => env('SMS_DRIVER','sms.ru'),

    'drivers' => [
        'sms.ru' => [
            'appId' => env('SMS_RU_APP_ID'),
            'url' => env('SMS_RU_URL'),
        ],
    ],

];