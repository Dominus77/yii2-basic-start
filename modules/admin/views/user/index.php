<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\web\JsExpression;
use app\assets\DatePickerAsset;
use modules\admin\Module;

/**
 * @var $this yii\web\View
 * @var $searchModel modules\admin\models\search\UserSearch
 * @var $dataProvider yii\data\ActiveDataProvider
 * @var $assignModel \modules\rbac\models\Assignment
 */

$language = substr(\Yii::$app->language, 0, 2);
DatePickerAsset::$language = $language;
DatePickerAsset::register($this);

$js = new JsExpression("
    initDatePicker();
    $(document).on('ready pjax:success', function() {
       initDatePicker();
    });

    function initDatePicker()
    {
        /** @see http://bootstrap-datepicker.readthedocs.io/en/latest/index.html */
        $('#datepicker').datepicker({
            language: '{$language}',
            autoclose: true,
            format: 'dd.mm.yyyy',
            zIndexOffset: 1001,
            orientation: 'bottom'
        });
    }
");
$this->registerJs($js, \yii\web\View::POS_END);

$this->title = Module::t('users', 'Users');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Administration'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Module::t('users', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
            </div>
            <div class="col-md-1">
                <?= app\widgets\PageSize::widget([
                    'label' => '',
                    'defaultPageSize' => 25,
                    'sizes' => [2 => 2, 5 => 5, 10 => 10, 15 => 15, 20 => 20, 25 => 25, 50 => 50, 100 => 100, 200 => 200],
                    'options' => [
                        'class' => 'form-control'
                    ]
                ]); ?>
            </div>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'filterSelector' => 'select[name="per-page"]',
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
                'headerOptions' => [
                    'style' => 'width:30px',
                ],
            ],
            [
                'attribute' => 'username',
                'filter' => Html::activeInput('text', $searchModel, 'username', [
                    'class' => 'form-control',
                    'placeholder' => Module::t('users', '- text -'),
                    'data' => [
                        'pjax' => true,
                    ],
                ]),
                'label' => Module::t('users', 'Users'),
                'format' => 'raw',
                'value' => function ($data) {
                    $view = Yii::$app->controller->view;
                    return $view->render('_avatar_column', ['model' => $data]);
                },
                'headerOptions' => ['width' => '120'],
            ],
            [
                'attribute' => 'email',
                'filter' => Html::activeInput('text', $searchModel, 'email', [
                    'class' => 'form-control',
                    'placeholder' => Module::t('users', '- text -'),
                    'data' => [
                        'pjax' => true,
                    ],
                ]),
                'format' => 'email',
                'contentOptions' => [
                    'style' => 'width:150px',
                ],
            ],
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->getStatusesArray(), [
                    'class' => 'form-control',
                    'prompt' => Module::t('users', '- all -'),
                    'data' => [
                        'pjax' => true,
                    ],
                ]),
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
                'contentOptions' => [
                    'style' => 'width:150px',
                ],
            ],
            [
                'attribute' => 'role',
                'filter' => Html::activeDropDownList($searchModel, 'role', $assignModel->getRolesArray(), [
                    'class' => 'form-control',
                    'prompt' => Module::t('users', '- all -'),
                    'data' => [
                        'pjax' => true,
                    ],
                ]),
                'format' => 'raw',
                'value' => function ($data) use ($assignModel) {
                    return $assignModel->getUserRoleName($data->id);
                },
                'contentOptions' => [
                    'style' => 'width:200px',
                ],
            ],
            [
                'attribute' => 'last_visit',
                'filter' => '<div class="form-group"><div class="input-group date"><div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>'
                    . Html::activeInput('text', $searchModel, 'date_from', [
                        'id' => 'datepicker',
                        'class' => 'form-control',
                        'placeholder' => Module::t('module', '- select -'),
                        'data' => [
                            'pjax' => true,
                        ],
                    ]) . '</div></div>',
                'format' => 'datetime',
                'headerOptions' => [
                    'style' => 'width: 165px;'
                ]
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'headerOptions' => [
                    'style' => 'width:80px',
                ],
                'contentOptions' => [
                    'class' => 'text-center',
                ],
            ],
        ],
    ]); ?>
</div>
