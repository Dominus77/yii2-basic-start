<?php

/**
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model \modules\users\models\ResetPasswordForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

$this->title = Module::t('module', 'Reset Password');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-default-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('module', 'Create a new password') ?>.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
            <div class="form-group">
                <?= $form->field($model, 'password')->passwordInput([
                    'class' => 'form-control',
                    'placeholder' => true
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-saved"></span> ' . Module::t('module', 'Save'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
