<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require (__DIR__ . '/params.php'),
    require (__DIR__ . '/params-local.php')
);

/**
 * Application configuration shared by all test types
 */
return [
    'id' => 'basic-tests',
    'language' => 'en',
    'basePath' => dirname(__DIR__),
    'defaultRoute' => 'main/default/index',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2basic_start_test',
            'tablePrefix' => 'tbl_',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'assetManager' => [
            'basePath' => __DIR__ . '/../web/assets',
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'modules\user\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
            // but if you absolutely need it set cookie domain to localhost
            /*
            'csrfCookie' => [
                'domain' => 'localhost',
            ],
            */
        ],
    ],
    'params' => $params,
];
