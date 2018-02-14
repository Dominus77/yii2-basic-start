<?php

namespace app\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Class RespondAsset
 * @package app\assets
 */
class RespondAsset extends AssetBundle
{
    public $sourcePath = '@bower/respond/dest';
    public $js = [
        'respond.min.js',
    ];
    public $jsOptions = [
        'condition' => 'lt IE 9',
        'position' => View::POS_HEAD,
    ];
}
