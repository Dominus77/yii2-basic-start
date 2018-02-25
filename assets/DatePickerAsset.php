<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Class DatePickerAsset
 * @package app\assets
 */
class DatePickerAsset extends AssetBundle
{
    /**
     * @var string
     */
    public static $language;

    /**
     * @var string
     */
    public $sourcePath = '@bower/bootstrap-datepicker/dist';

    /**
     * @var array
     */
    public $css = [];

    /**
     * @var array
     */
    public $js = [];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $min = YII_ENV_DEV ? '' : '.min';
        $language = self::$language ? self::$language : substr(\Yii::$app->language, 0, 2);
        $this->css = [
            'css/bootstrap-datepicker3' . $min . '.css',
        ];
        $this->js = [
            'js/bootstrap-datepicker' . $min . '.js',
            'locales/bootstrap-datepicker.' . $language . '.min.js',
        ];
    }

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
