<?php

return [
    'id' => 'app-console',
    'language' => 'en',
    'controllerNamespace' => 'app\commands',
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationNamespaces' => [
                'modules\user\migrations',
            ],
        ],
    ],
    'components' => [
    ],
];
