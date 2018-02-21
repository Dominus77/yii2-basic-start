<?php

use yii\helpers\Html;
use modules\user\widgets\AvatarWidget;
use modules\user\Module;

/* @var $this yii\web\View */
/* @var $model modules\user\models\User */
?>

<div class="user-profile-tabs-_update_avatar text-center">
    <p>
        <?= AvatarWidget::widget([
            'size' => 150,
            'imageOptions' => [
                'class' => 'img-thumbnail'
            ]
        ]) ?>
    </p>
    <p><?= Module::t('module', 'To change the avatar, please use the {:link} service.', [':link' => Html::a('Gravatar', 'http://www.gravatar.com', ['target' => '_blank'])]) ?></p>
</div>
