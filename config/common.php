<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'name' => 'Yii2-basic-start',
    'language' => 'ru',
    'basePath' => dirname(__DIR__),
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'bootstrap' => [
        'log',
        'modules\main\Bootstrap',
        'modules\users\Bootstrap',
        'modules\admin\Bootstrap',
        'modules\rbac\Bootstrap',
    ],
    'modules' => [
        'main' => [
            'class' => 'modules\main\Module',
        ],
        'users' => [
            'class' => 'modules\users\Module',
        ],
        'rbac' => [
            'class' => 'modules\rbac\Module',
            'params' => [
                'userClass' => 'modules\users\models\User',
            ]
        ],
        'admin' => [
            'class' => 'modules\admin\Module',
        ],
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'charset' => 'utf8',
            'username' => '',
            'password' => '',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_a:(error)>' => 'site/<a>',
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'messageConfig' => [
                'charset' => 'UTF-8'
            ],
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.yandex.ru',
                'username' => '',
                'password' => '',
                'port' => '465',
                'encryption' => 'ssl',
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'class' => 'yii\log\Dispatcher',
        ],
    ],
    'params' => $params,
];
