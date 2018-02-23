<?php

/* @var $this yii\web\View */
/* @var $user modules\users\models\User */

use yii\helpers\Html;
use modules\users\Module;

$urlManager = Yii::$app->urlManager;
$confirmLink = $urlManager->createAbsoluteUrl(['users/default/email-confirm', 'token' => $user->email_confirm_token]);
$link = $urlManager->createAbsoluteUrl(['main/default/index']);
?>

<div class="email-confirm">
    <p><?= Module::t('module', 'Hello!'); ?></p>
    <p><?= Module::t('module', 'When registering on the site {:Website} you or someone else has indicated the address of your email.', [':Website' =>  Html::a(Yii::$app->name, $link)]) ?></p>
    <p><?= Module::t('module', 'If you did not do this, then just ignore this letter.'); ?></p>
    <p><?= Module::t('module', 'To activate your account, please follow the link below or copy it to your browser.'); ?></p>
    <p><?= Html::a(Html::encode($confirmLink), $confirmLink) ?></p>
    <p><?= Module::t('module', 'The letter was sent by the robot and you do not need to respond to it.') ?></p>
    <br>
    <p><?= Module::t('module', 'Sincerely, website administration {:Website}', [':Website' =>  Html::a(Yii::$app->name, $link)]) ?></p>
</div>
