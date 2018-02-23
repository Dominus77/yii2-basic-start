<?php

/**
 * @var $this yii\web\View
 * @var $form yii\bootstrap\ActiveForm
 * @var $model \modules\users\models\SignupForm
 */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use modules\users\Module;

$this->title = Module::t('module', 'Check in');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="users-default-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Module::t('module', 'Please fill in the following fields to sign up'); ?>:</p>

    <div class="row">
        <div class="col-md-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'username')->textInput([
                'class' => 'form-control',
                'placeholder' => true
            ]) ?>

            <?= $form->field($model, 'email')->textInput([
                'class' => 'form-control',
                'placeholder' => true
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'class' => 'form-control',
                'placeholder' => true
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-ok"></span> ' . Module::t('module', 'Sign Up'), ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
