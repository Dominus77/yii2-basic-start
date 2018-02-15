<?php

return [
    'components' => [
        'request' => [
            'cookieValidationKey' => 'Q2vjRFVbitk788zxKWeWX9GA31nTX-qg',
        ],
        'assetManager' => [
            'linkAssets' => false,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'logFile' => '@app/runtime/logs/web-error.log'
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'logFile' => '@app/runtime/logs/web-warning.log'
                ],
            ],
        ],
    ],
];
