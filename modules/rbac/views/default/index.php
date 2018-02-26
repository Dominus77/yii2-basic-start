<?php

use yii\helpers\Html;
use modules\rbac\widgets\RbacMenu;
use modules\rbac\Module;

/* @var $this yii\web\View */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = Module::t('module', 'RBAC');
?>

<div class="rbac-default-index">
    <div class="row">
        <div class="col-lg-3">
            <?= RbacMenu::widget() ?>
        </div>
        <div class="col-lg-9">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
                Модуль управления доступом на основе ролей
            </p>
        </div>
    </div>
</div>
