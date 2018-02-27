<?php

namespace modules\rbac\widgets;

use yii\bootstrap\Widget;
use yii\widgets\Menu;
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
                'label' => Module::t('module', 'Permissions') . '<span class="caret"></span>',
                'url' => ['permissions/index'],
                'items' => [
                    [
                        'label' => '+ ' . Module::t('module', 'New Permission'),
                        'url' => ['permissions/create'],
                    ],
                ],
            ],
            [
                'label' => Module::t('module', 'Roles') . '<span class="caret"></span>',
                'url' => ['roles/index'],
                'items' => [
                    [
                        'label' => '+ ' . Module::t('module', 'New Role'),
                        'url' => ['roles/create'],
                    ],
                ],
            ],
            [
                'label' => Module::t('module', 'Assign rights'),
                'url' => ['assign/index'],
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
