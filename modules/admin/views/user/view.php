<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use modules\users\widgets\AvatarWidget;
use modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model modules\admin\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Administration'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('users', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs(new yii\web\JsExpression("
    $(function () {
        $('[data-toggle=\"tooltip\"]').tooltip();        
    });
"), yii\web\View::POS_END);
?>
<div class="admin-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-12">
            <p class="pull-right">
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::t('users', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('<span class="glyphicon glyphicon-pencil"></span> ' . Module::t('users', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">
            <?= AvatarWidget::widget([
                'email' => $model->email,
                'imageOptions' => [
                    'class' => 'profile-user-img img-responsive img-circle',
                    'style' => 'width:100px',
                    'alt' => 'avatar_' . $model->username,
                ]]) ?>
        </div>
        <div class="col-sm-10">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'username',
                    'email:email',
                    'first_name',
                    'last_name',
                    [
                        'attribute' => 'role',
                        'format' => 'raw',
                        'value' => function ($model) {
                            $assignModel = new \modules\rbac\models\Assignment();
                            return $assignModel->getRoleName($model->id);
                        },
                    ],
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
                        'value' => function ($model) {
                            $key = Html::tag('code', $model->auth_key, ['id' => 'authKey']);
                            $link = Html::a(Module::t('users', 'Generate'), ['generate-auth-key', 'id' => $model->id], [
                                'class' => 'btn btn-sm btn-default',
                                'title' => Module::t('users', 'Generate new key'),
                                'data' => [
                                    'toggle' => 'tooltip',
                                ],
                                'onclick' => "                                
                                $.ajax({
                                    type: 'POST',
                                    cache: false,
                                    url: this.href,
                                    success: function(response) {                                       
                                        if(response.success) {
                                            $('#authKey').html(response.success);
                                        }
                                    }
                                });
                                return false;
                            ",
                            ]);
                            return $key . ' ' . $link;
                        }
                    ],
                    'password_hash',
                    'password_reset_token',
                    'email_confirm_token:email',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>
        </div>
    </div>
</div>
