<?php

/* @var $this yii\web\View */
/* @var $user modules\user\models\User */

use modules\user\Module;

$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>

<?= Module::t('mail', 'HELLO {username}', ['username' => $user->username]); ?>!

<?= Module::t('mail', 'FOLLOW_TO_CONFIRM_EMAIL') ?>:

<?= $confirmLink ?>

<?= Module::t('mail', 'IGNORE_IF_DO_NOT_REGISTER') ?>
