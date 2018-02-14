<?php

namespace modules\user\traits;

use Yii;
use modules\user\Module;

/**
 * Trait ModuleTrait
 *
 * @property-read Module $module
 * @package modules\user\traits
 */
trait ModuleTrait
{
    /**
     * @return null|\yii\base\Module
     */
    public function getModule()
    {
        return Yii::$app->getModule('user');
    }
}
