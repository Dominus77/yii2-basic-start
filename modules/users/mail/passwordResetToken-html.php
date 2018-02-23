<?php

/* @var $this yii\web\View */
/* @var $user modules\users\models\User */

use yii\helpers\Html;
use modules\users\Module;

$urlManager = Yii::$app->urlManager;
$resetLink = $urlManager->createAbsoluteUrl(['users/default/reset-password', 'token' => $user->password_reset_token]);
$link = $urlManager->createAbsoluteUrl(['main/default/index']);
?>

<div class="password-reset">
    <p><?= Module::t('module', 'Hello {username}', ['username' => $user->username]); ?>!</p>
    <p><?= Module::t('module', 'You or someone else indicated your email address in the form of a password reset on the {:Website}. If you did not then just ignore this email.', [':Website' => Html::a(Yii::$app->name, $link)]) ?></p>
    <p><?= Module::t('module', 'To reset your password follow the link below, or copy it to your browser.') ?></p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
    <p><?= Module::t('module', 'The letter was sent by the robot and you do not need to respond to it.') ?></p>
    <br>
    <p><?= Module::t('module', 'Sincerely, website administration {:Website}', [':Website' => Html::a(Yii::$app->name, $link)]) ?>.</p>
</div>
