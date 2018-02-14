<?php

namespace modules\user;

use Yii;

/**
 * Class Bootstrap
 * @package modules\user
 */
class Bootstrap
{
    public function __construct()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['modules/user/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/user/messages',
            'fileMap' => [
                'modules/user/module' => 'module.php',
            ],
        ];

        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules(
            [
                // Declaration of rules here
                '<_a:(login|logout)>' => 'user/default/<_a>',
            ]
        );
    }
}
