<?php

use yii\helpers\Html;
use yii\grid\GridView;
use modules\admin\Module;

/* @var $this yii\web\View */
/* @var $searchModel modules\admin\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Module::t('users', 'Users');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Administration'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-plus"></span> ' . Module::t('users', 'Create'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            'email:email',
            [
                'attribute' => 'status',
                'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusesArray, [
                    'class' => 'form-control',
                    'prompt' => Module::t('users', '- all -'),
                    'data' => [
                        'pjax' => true,
                    ],
                ]),
                'format' => 'raw',
                'value' => function ($model) {
                    return $model->statusLabelName;
                },
            ],
            'last_visit:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
