<?php

namespace tests\models;

use Yii;
use modules\users\models\LoginForm;
use app\fixtures\User as UserFixture;

/**
 * Class LoginFormTest
 * @package tests\models
 */
class LoginFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \_generated\UnitTesterActions
     */
    protected $tester;

    /**
     * @inheritdoc
     */
    public function _before()
    {
        $this->tester->haveFixtures([
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ]);
    }

    /**
     * @inheritdoc
     */
    public function testLoginNoUser()
    {
        $model = new LoginForm([
            'email' => 'not_existing_username@test.loc',
            'password' => 'not_existing_password',
        ]);

        expect('model should not login users', $model->login())->false();
        expect('users should not be logged in', Yii::$app->user->isGuest)->true();
    }

    /**
     * @inheritdoc
     */
    public function testLoginWrongPassword()
    {
        Yii::$app->getRequest()->cookieValidationKey = 'test';
        $model = new LoginForm([
            'email' => 'bayer.hudson@test.loc',
            'password' => 'wrong_password',
        ]);

        expect('model should not login users', $model->login())->false();
        expect('error message should be set', $model->errors)->hasKey('password');
        expect('users should not be logged in', Yii::$app->user->isGuest)->true();
    }

    /**
     * @inheritdoc
     */
    public function testLoginCorrect()
    {
        Yii::$app->getRequest()->cookieValidationKey = 'test';
        $model = new LoginForm([
            'email' => 'im.tester@rutherford.com',
            'password' => 'password_0',
        ]);

        expect('model should login users', $model->login())->true();
        expect('error message should not be set', $model->errors)->hasntKey('password_hash');
        expect('users should be logged in', Yii::$app->user->isGuest)->false();
    }
}
