<?php

/* @var $this yii\web\View */
/* @var $user modules\user\models\User */

use modules\user\Module;

$urlManager = Yii::$app->urlManager;
$confirmLink = $urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
?>

<?= Module::t('module', 'Hello!'); ?>

<?= Module::t('module', 'When registering on the site {:Website} you or someone else has indicated the address of your email.', [':Website' => Yii::$app->name]) ?>

<?= Module::t('module', 'If you did not do this, then just ignore this letter.'); ?>

<?= Module::t('module', 'To activate your account, please follow the link below or copy it to your browser.'); ?>

<?= $confirmLink ?>

<?= Module::t('module', 'The letter was sent by the robot and you do not need to respond to it.') ?>


<?= Module::t('module', 'Sincerely, website administration {:Website}', [':Website' => Yii::$app->name]) ?>
