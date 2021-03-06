<?php

use modules\users\models\PasswordResetRequestForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

/**
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model PasswordResetRequestForm
 */

$this->title = Module::t('module', 'Password Reset Form');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-default-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t(
        'module',
        'Enter your email address and press {:Send}',
        [':Send' => Module::t('module', 'Send')]
    ); ?></p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
            <div class="form-group">
                <?= $form->field($model, 'email')->textInput([
                    'class' => 'form-control',
                    'placeholder' => true
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(
                    '<span class="glyphicon glyphicon-send"></span> ' . Module::t(
                        'module',
                        'Send'
                    ),
                    ['class' => 'btn btn-primary']
                ) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
