<?php

/* @var $this yii\web\View */
/* @var $user modules\users\models\User */

use modules\users\Module;

$urlManager = Yii::$app->urlManager;
$confirmLink = $urlManager->createAbsoluteUrl(['users/default/email-confirm', 'token' => $user->email_confirm_token]);


echo Module::t('module', 'Hello!');

echo Module::t('module', 'When registering on the site {:Website} you or someone else has indicated the address of your email.', [':Website' => Yii::$app->name]);

echo Module::t('module', 'If you did not do this, then just ignore this letter.');

echo Module::t('module', 'To activate your account, please follow the link below or copy it to your browser.');

echo $confirmLink;

echo Module::t('module', 'The letter was sent by the robot and you do not need to respond to it.');


echo Module::t('module', 'Sincerely, website administration {:Website}', [':Website' => Yii::$app->name]);
