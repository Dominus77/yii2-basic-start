<?php

namespace modules\admin;

use Yii;

/**
 * Class Module
 * @package modules\admin
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setViewPath('@modules/admin/views');
    }

    /**
     * @param string $category
     * @param string $message
     * @param array $params
     * @param null|string $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/admin/' . $category, $message, $params, $language);
    }
}
