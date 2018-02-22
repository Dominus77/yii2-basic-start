<?php

use yii\helpers\ArrayHelper;

$params = ArrayHelper::merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

/**
 * Application configuration shared by all test types
 */
return ArrayHelper::merge([
    'id' => 'basic-tests',
    'language' => 'en-US',
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
            'username' => '',
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
            'class' => 'codemix\localeurls\UrlManager',
            'showScriptName' => true,
        ],
        'user' => [
            'identityClass' => 'modules\user\models\User',
        ],
        'request' => [
            'cookieValidationKey' => 'test',
            'enableCsrfValidation' => false,
        ],
    ],
    'params' => $params,
], require(__DIR__ . '/test-local.php'));
