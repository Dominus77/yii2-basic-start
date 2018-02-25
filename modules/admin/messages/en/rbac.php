<?php

use yii\helpers\ArrayHelper;

/** @var array $langFile */
$langFile = require(dirname(dirname(dirname(__DIR__))) . '/rbac/messages/en/module.php');

return ArrayHelper::merge($langFile, []);
