<?php

use yii\helpers\ArrayHelper;

/** @var array $langFile */
$langFile = require(dirname(dirname(dirname(__DIR__))) . '/users/messages/en/module.php');

return ArrayHelper::merge($langFile, [
    'Users' => 'Users',
    'Create User' => 'Create User',
    'Update User: {nameAttribute}' => 'Update User: {nameAttribute}',

    'Password' => 'Password',

    'Create' => 'Create',
    'Update' => 'Update',
    'Save' => 'Save',
    'Delete' => 'Delete',

    '- all -' => '- all -',
    '- select -' => '- select -',
    '- text -' => '- text -',

    'This username is already taken.' => 'This username is already taken.',
    'This email is already taken.' => 'This email is already taken.',

    'Click to change the status' => 'Click to change the status',
]);
