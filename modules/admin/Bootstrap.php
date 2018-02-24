<?php

namespace modules\admin;

use Yii;

/**
 * Class Bootstrap
 * @package modules\admin
 */
class Bootstrap
{
    public function __construct()
    {
        $i18n = Yii::$app->i18n;
        $i18n->translations['modules/admin/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@modules/admin/messages',
            'fileMap' => [
                'modules/admin/module' => 'module.php',
                'modules/admin/users' => 'users.php',
            ],
        ];

        $urlManager = Yii::$app->urlManager;
        $urlManager->addRules(
            [
                // Declaration of rules here
                'admin/users' => 'admin/user/index',
                'admin/user/<id:\d+>/<_a:[\w\-]+>' => 'admin/user/<_a>',
                'admin/users/<_a:[\w\-]+>' => 'admin/user/<_a>',

                'admin' => 'admin/default/index',
                'admin/<_a:[\w\-]+>' => 'admin/default/<_a>',
            ]
        );
    }
}
