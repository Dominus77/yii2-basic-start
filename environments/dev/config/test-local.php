<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yii2_basic_start_test',
            'tablePrefix' => 'tbl_',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
    ],
];
