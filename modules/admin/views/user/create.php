<?php

use yii\helpers\Html;
use modules\admin\Module;

/* @var $this yii\web\View */
/* @var $model modules\admin\models\User */

$this->title = Module::t('users', 'Create User');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Administration'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('users', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
