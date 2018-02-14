<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

/**
 * This CSS Themes Bootstrap
 * ------------
 * cerulean
 * cosmo
 * cyborg
 * darkly
 * default
 * flatly
 * journal
 * lumen
 * paper
 * readable
 * sandstone
 * simplex
 * slate
 * spacelab
 * superhero
 * united
 * yeti
 * ------------
 * @package /app/assets/bootstrap
 * @var string
 */
$css_theme = 'united';

$config = [
    'id' => 'basic',
    'name' => 'Yii2-basic-start',
    'language' => 'ru',
    'timeZone' => 'Europe/Moscow',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'defaultRoute' => 'main/default/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'log',
        'modules\main\Bootstrap',
        'modules\user\Bootstrap',
    ],
    'modules' => [
        'main' => [
            'class' => 'modules\main\Module',
        ],
        'user' => [
            'class' => 'modules\user\Module',
        ],
    ],
    'components' => [
        'request' => [
            'baseUrl' => '',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'O5UjQrxzJu57vuD3AxYDsvcdS9tuEDpA',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => '@app/assets/bootstrap',
                    'css' => [
                        YII_ENV_DEV ? $css_theme . '/bootstrap.css' : $css_theme . '/bootstrap.min.css',
                    ]
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'modules\user\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                //'<_a:[\w\-]+>' => 'site/<_a>',
                //'login' => 'site/login',
                '<_a:(error)>' => 'site/<_a>',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
