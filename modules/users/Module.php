<?php

namespace modules\users;

use Yii;
use yii\console\Application as ConsoleApplication;

/**
 * Class Module
 * @package modules\users
 */
class Module extends \yii\base\Module
{
    /**
     * @var int
     */
    public $emailConfirmTokenExpire = 259200; // 3 days

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'modules\users\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->setViewPath('@modules/users/views');
        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'modules\users\commands';
        }
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
        return Yii::t('modules/users/' . $category, $message, $params, $language);
    }
}
