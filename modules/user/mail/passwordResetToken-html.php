<?php

/* @var $this yii\web\View */
/* @var $user modules\user\models\User */

use yii\helpers\Html;
use modules\user\Module;

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/reset-password', 'token' => $user->password_reset_token]);
?>

<div class="password-reset">
    <p><?= Module::t('mail', 'Hello {username}', ['username' => $user->username]); ?>,</p>
    <p><?= Module::t('mail', 'Click the link to set a new password.') ?>:</p>
    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
