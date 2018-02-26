<?php

use yii\helpers\Html;
use yii\helpers\Url;
use modules\rbac\widgets\RbacMenu;
use modules\rbac\Module;

/* @var $this yii\web\View */

$this->title = Module::t('module', 'Role Based Access Control');
$this->params['breadcrumbs'][] = ['label' => Module::t('module', 'RBAC'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('module', 'Options');
?>

<div class="rbac-default-options">
    <div class="row">
        <div class="col-lg-3">
            <?= RbacMenu::widget() ?>
        </div>
        <div class="col-lg-9">
            <h1><?= Module::t('module', 'Options') ?></h1>
            <p>
                Сброс настроек по умолчанию:
                <a href="<?= Url::to(['init']) ?>" data-toggle="tooltip" data-method="post"><?= Module::t('module', 'Reset rbac') ?></a>
            </p>
        </div>
    </div>
</div>
