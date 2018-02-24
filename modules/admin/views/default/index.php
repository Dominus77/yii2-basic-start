<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use modules\admin\Module;

/* @var $this yii\web\View */

$this->title = Module::t('module', 'Administration');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="admin-default-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="row">
        <div class="col-lg-3">
            <?php $menuItems = [
                [
                    'label' => '<span class="glyphicon glyphicon-user"></span> ' . Module::t('users', 'Users'),
                    'url' => ['/admin/user/index']
                ],
            ];
            echo Nav::widget([
                'options' => ['class' => 'nav nav-pills nav-stacked'],
                'activateParents' => true,
                'encodeLabels' => false,
                'items' => array_filter($menuItems)
            ]); ?>
        </div>
    </div>
</div>
