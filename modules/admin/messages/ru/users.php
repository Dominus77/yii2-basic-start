<?php

use yii\helpers\ArrayHelper;

/** @var array $langFile */
$langFile = require(dirname(dirname(dirname(__DIR__))) . '/users/messages/ru/module.php');

return ArrayHelper::merge($langFile, [
    'Users' => 'Пользователи',
    'Create User' => 'Создание пользователя',
    'Update User: {nameAttribute}' => 'Редактировать пользователя: {nameAttribute}',

    'Password' => 'Пароль',

    'Create' => 'Создать',
    'Update' => 'Редактировать',
    'Save' => 'Сохранить',
    'Delete' => 'Удалить',

    '- all -' => '- все -',
    '- select -' => '- выбрать -',
    '- text -' => '- текст -',

    'This username is already taken.' => 'Такое имя пользователя уже существует.',
    'This email is already taken.' => 'Такой email уже существует.',

    'Click to change the status' => 'Клик для смены статуса',
]);
