<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model modules\admin\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Administration'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('users', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::t('users', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::t('users', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',
            'first_name',
            'last_name',
            [
                'attribute' => 'status',
                'format' => 'raw',
                'value' => function ($model) {
                    $view = Yii::$app->controller->view;
                    /** @var object $identity */
                    $identity = Yii::$app->user->identity;
                    /** @var $model modules\admin\models\User */
                    if ($model->id != $identity->id && !$model->isSuperAdmin($model->id)) {
                        $view->registerJs("$('#status_link_" . $model->id . "').click(handleAjaxLink);", \yii\web\View::POS_READY);
                        return Html::a($model->statusLabelName, ['status', 'id' => $model->id], [
                            'id' => 'status_link_' . $model->id,
                            'title' => Module::t('users', 'Click to change the status'),
                            'data' => [
                                'toggle' => 'tooltip',
                            ],
                        ]);
                    }
                    return $model->statusLabelName;
                },
            ],
            'last_visit:datetime',
            [
                'attribute' => 'auth_key',
                'format' => 'raw',
                'value' => $this->render('_auth_key', ['model' => $model]),
            ],
            'password_hash',
            'password_reset_token',
            'email_confirm_token:email',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'registration_type',
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->registrationType;
                },
            ],
        ],
    ]) ?>

</div>
