<?php

use yii\helpers\Html;
use modules\rbac\widgets\RbacMenu;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Role */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Create');
?>

<div class="rbac-roles-create">
    <div class="row">
        <div class="col-lg-3">
            <?= RbacMenu::widget() ?>
        </div>
        <div class="col-lg-9">
            <h1><?= Module::t('module', 'Create Role') ?></h1>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ' . Module::t('module', 'Create'), [
                    'class' => 'btn btn-success', 'form' => 'form-role'
                ]) ?>
            </div>
        </div>
    </div>
</div>
