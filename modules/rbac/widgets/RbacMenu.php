<?php

namespace modules\rbac\widgets;

use yii\bootstrap\Widget;
use yii\widgets\Menu;
use yii\helpers\Html;
use modules\rbac\Module;

/**
 * Class RbacMenu
 * @package modules\rbac\widgets
 */
class RbacMenu extends Widget
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->registerAssets();
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function run()
    {
        echo Menu::widget([
            'options' => ['class' => 'nav nav-pills nav-stacked rbac-menu'],
            'activateItems' => true,
            'activateParents' => true,
            'encodeLabels' => false,
            'submenuTemplate' => "\n<ul class='nav sub-menu'>\n{items}\n</ul>\n",
            'items' => array_filter($this->items()),
        ]);
    }

    /**
     * @return array
     */
    public function items()
    {
        return [
            [
                'label' => Module::t('module', 'Permissions'),
                'url' => ['permissions/index'],
                'items' => [
                    [
                        'label' => Module::t('module', 'Create Permission'),
                        'url' => ['permissions/create'],
                    ],
                ],
            ],
            [
                'label' => Module::t('module', 'Roles'),
                'url' => ['roles/index'],
                'items' => [
                    [
                        'label' => Module::t('module', 'Create Role'),
                        'url' => ['roles/create'],
                    ],
                ],
            ],
            [
                'label' => Module::t('module', 'Assign rights'),
                'url' => ['assign/index'],
            ],
            [
                'label' => Module::t('module', 'Options'),
                'url' => ['default/options'],
                /*'linkOptions' => [
                    'title' => Module::t('module', 'Reset rbac'),
                    'data' => [
                        'toggle' => 'tooltip',
                        'method' => 'post',
                        'confirm' => Module::t('module', 'Attention! All previously created permissions and roles will be deleted. Do you really want to perform this action?'),
                    ],
                ],*/
            ],
        ];
    }

    /**
     * Register resource
     */
    protected function registerAssets()
    {
        $view = $this->view;
        RbacMenuAsset::register($view);
    }
}
