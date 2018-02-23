<?php

namespace tests\models;

use app\fixtures\User as UserFixture;
use modules\users\models\User;

/**
 * Class UserTest
 * @package tests\models
 */
class UserTest extends \Codeception\Test\Unit
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
    public function testFindUserById()
    {
        /** @var $user \modules\users\models\User */
        expect_that($user = User::findIdentity(3));
        expect($user->username)->equals('imtester');

        expect_not(User::findIdentity(999));
    }

    /**
     * @inheritdoc
     */
    public function testFindUserByAccessToken()
    {
        /** @var $user \modules\users\models\User */
        expect_that($user = User::findIdentityByAccessToken('iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv'));
        expect($user->username)->equals('imtester');

        expect_not(User::findIdentityByAccessToken('non-existing'));
    }

    /**
     * @inheritdoc
     */
    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('imtester'));
        expect_not(User::findByUsername('not-imtester'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser($user)
    {
        $user = User::findByUsername('imtester');
        expect_that($user->validateAuthKey('iwTNae9t34OmnK6l4vT4IeaTk-YWI2Rv'));
        expect_not($user->validateAuthKey('test102key'));

        expect_that($user->validatePassword('password_0'));
        expect_not($user->validatePassword('123456'));
    }
}
