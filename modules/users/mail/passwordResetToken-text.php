<?php

/* @var $this yii\web\View */
/* @var $user modules\users\models\User */

use modules\users\Module;

$urlManager = Yii::$app->urlManager;
$resetLink = $urlManager->createAbsoluteUrl(['users/default/reset-password', 'token' => $user->password_reset_token]);
?>

<?= Module::t('module', 'Hello {username}', ['username' => $user->username]); ?>!

<?= Module::t('module', 'You or someone else indicated your email address in the form of a password reset on the {:Website}. If you did not then just ignore this email.', [':Website' => Yii::$app->name]) ?>

<?= Module::t('module', 'To reset your password follow the link below, or copy it to your browser.') ?>

<?= $resetLink ?>

<?= Module::t('module', 'The letter was sent by the robot and you do not need to respond to it.') ?>


<?= Module::t('module', 'Sincerely, website administration {:Website}', [':Website' => Yii::$app->name]) ?>
