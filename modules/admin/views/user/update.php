<?php

use yii\helpers\Html;
use modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model modules\admin\models\User */

$this->title = Module::t('users', 'Update User: {nameAttribute}', [
    'nameAttribute' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Administration'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('users', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Module::t('users', 'Update');
?>
<div class="admin-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
