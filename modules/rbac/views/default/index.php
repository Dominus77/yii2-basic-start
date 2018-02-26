<?php

use yii\helpers\Url;
use modules\rbac\widgets\RbacMenu;
use modules\rbac\Module;

/* @var $this yii\web\View */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = Module::t('module', 'RBAC');
$confirm = Module::t('module', 'Attention! All previously created permissions and roles will be deleted. Do you really want to perform this action?');
?>

<div class="rbac-default-index">
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
            <h2><?= Module::t('module', 'RBAC') ?></h2>
            <p class="lead">
                <?= Module::t('module', 'Role Based Access Control') ?>
            </p>
            <p>
                <a href="<?= Url::to(['init']) ?>" data-toggle="tooltip" data-method="post"
                   data-confirm="<?= $confirm ?>">
                    <span class="glyphicon glyphicon-exclamation-sign"></span> <?= Module::t('module', 'Reset rbac') ?>
                </a>
            </p>
        </div>
    </div>
</div>
