<?php

namespace modules\admin\traits;

use Yii;
use modules\admin\Module;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 * @package modules\admin\traits
 */
trait ModuleTrait
{
    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('admin');
    }
}
