<?php

namespace modules\rbac\widgets;

use yii\web\AssetBundle;

/**
 * Class RbacMenuAsset
 * @package modules\rbac\widgets
 */
class RbacMenuAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath;

    /**
     * @var array
     */
    public $css = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->sourcePath = __DIR__ . '/src';
        $this->css = [
            'css/style.css',
        ];
    }

    public $publishOptions = [
        'forceCopy' => false,
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
}
