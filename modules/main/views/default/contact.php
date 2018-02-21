<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \modules\main\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use modules\main\Module;

$this->title = Module::t('module', 'Contact');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="main-default-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')): ?>

        <div class="alert alert-success">
            <?= Module::t('module','Thank you for contacting us. We will respond to you as soon as possible.') ?>
        </div>

        <p>
            Note that if you turn on the Yii debugger, you should be able
            to view the mail message on the mail panel of the debugger.
            <?php if (Yii::$app->mailer->useFileTransport): ?>
                Because the application is in development mode, the email is not sent but saved as
                a file under <code><?= Yii::getAlias(Yii::$app->mailer->fileTransportPath) ?></code>.
                                                                                                    Please configure the
                <code>useFileTransport</code> property of the <code>mail</code>
                application component to be false to enable email sending.
            <?php endif; ?>
        </p>

    <?php else: ?>

        <p>
            If you have business inquiries or other questions, please fill out the following form to contact us.
            Thank you.
        </p>

        <div class="row">
            <div class="col-lg-5">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?php if ($model->scenario === $model::SCENARIO_GUEST) : ?>
                    <?= $form->field($model, 'name')->textInput(['autofocus' => true, 'placeholder' => true]) ?>

                    <?= $form->field($model, 'email')->textInput(['placeholder' => true]) ?>
                <?php endif; ?>
                <?= $form->field($model, 'subject')->textInput(['placeholder' => true]) ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6, 'placeholder' => true]) ?>

                <?php if ($model->scenario === $model::SCENARIO_GUEST) : ?>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
                        'captchaAction' => Url::to('/main/default/captcha'),
                        'options' => [
                            'placeholder' => true
                        ]
                    ]) ?>
                <?php endif; ?>

                <div class="form-group">
                    <?= Html::submitButton('<span class="glyphicon glyphicon-send" aria-hidden="true"></span> ' . Module::t('module', 'Submit'), ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

    <?php endif; ?>
</div>
