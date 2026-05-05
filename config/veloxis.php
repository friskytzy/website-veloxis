<?php

return [
    'couriers' => [
        'JNE' => [
            'provider' => 'rajaongkir',
            'base_cost' => 18000,
            'active' => true,
        ],
        'J&T' => [
            'provider' => 'rajaongkir',
            'base_cost' => 17000,
            'active' => true,
        ],
        'SiCepat' => [
            'provider' => 'rajaongkir',
            'base_cost' => 16000,
            'active' => true,
        ],
    ],
    'payments' => [
        'Transfer Bank' => [
            'provider' => 'manual',
            'active' => true,
        ],
        'OVO' => [
            'provider' => 'xendit',
            'active' => true,
        ],
        'GoPay' => [
            'provider' => 'midtrans',
            'active' => true,
        ],
        'DANA' => [
            'provider' => 'xendit',
            'active' => true,
        ],
        'COD' => [
            'provider' => 'manual',
            'active' => true,
        ],
    ],
];
