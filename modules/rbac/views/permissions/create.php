<?php

use yii\helpers\Html;
use modules\rbac\widgets\RbacMenu;
use modules\rbac\Module;

/* @var $this yii\web\View */
/* @var $model modules\rbac\models\Permission */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['default/index']];
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Create');
?>

<div class="rbac-permissions-create">
    <div class="row">
        <div class="col-lg-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><?= Module::t('module', 'Menu') ?></h3>
                </div>
                <div class="panel-body">
                    <?= RbacMenu::widget() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <h2><?= Module::t('module', 'New Permission') ?></h2>
            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>
            <div class="form-group">
                <?= Html::submitButton('<span class="glyphicon glyphicon-plus"></span> ' . Module::t('module', 'Create'), [
                    'class' => 'btn btn-success', 'form' => 'form-permission'
                ]) ?>
            </div>
        </div>
    </div>
</div>
