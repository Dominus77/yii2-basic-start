<?php

/**
 * @var $this yii\web\View
 * @var $model modules\users\models\Profile
 * @var $form yii\widgets\ActiveForm
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

?>

<div class="users-frontend-profile-tabs-_update_password">
    <?php
    $model->scenario = $model::SCENARIO_PASSWORD_UPDATE;
    $form = ActiveForm::begin([
        'action' => Url::to(['update-password']),
        'validationUrl' => ['ajax-validate-password-form'],
        'layout' => 'horizontal',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-2',
                'offset' => 'col-sm-offset-2',
                'wrapper' => 'col-sm-3',
            ],
        ],
    ]);
    ?>

    <?= $form->field($model, 'newPassword')->passwordInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => true,
    ]) ?>

    <?= $form->field($model, 'newPasswordRepeat')->passwordInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => true,
    ]) ?>

    <?= $form->field($model, 'currentPassword', ['enableAjaxValidation' => true])->passwordInput([
        'maxlength' => true,
        'class' => 'form-control',
        'placeholder' => true,
    ]) ?>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> ' . Module::t('module', 'Save'), [
                'class' => 'btn btn-primary',
                'name' => 'submit-button',
            ]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
