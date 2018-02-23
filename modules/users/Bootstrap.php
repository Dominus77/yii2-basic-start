<?php

namespace modules\users;

use Yii;

/**
 * Class Bootstrap
 * @package modules\users
 */
class Bootstrap
{
    public function __construct()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['modules/users/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/users/messages',
            'fileMap' => [
                'modules/users/module' => 'module.php',
            ],
        ];

        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules(
            [
                // Declaration of rules here
                '<_a:(login|logout|request-password-reset|reset-password|signup|email-confirm)>' => 'users/default/<_a>',
                'profile' => 'users/profile/index',
                'profile/<_a:[\w\-]+>' => 'users/profile/<_a>',
            ]
        );
    }
}
