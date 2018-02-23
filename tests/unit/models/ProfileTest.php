<?php

namespace tests\models;

use app\fixtures\User as UserFixture;
use modules\users\models\Profile;

/**
 * Class ProfileTest
 * @package tests\models
 */
class ProfileTest extends \Codeception\Test\Unit
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
    public function testValidateUpdatePasswordAllEmpty()
    {
        $profile = Profile::findByUsername('imtester');
        $profile->scenario = $profile::SCENARIO_PASSWORD_UPDATE;
        $profile->newPassword = '';
        $profile->newPasswordRepeat = '';
        $profile->currentPassword = '';
        expect_not($profile->validate());
    }

    /**
     * @inheritdoc
     */
    public function testValidateUpdatePasswordEmptyNewPassword()
    {
        $profile = Profile::findByUsername('imtester');
        $profile->scenario = $profile::SCENARIO_PASSWORD_UPDATE;
        $profile->newPassword = '';
        $profile->newPasswordRepeat = '123456';
        $profile->currentPassword = 'password_0';
        expect_not($profile->validate());
    }

    /**
     * @inheritdoc
     */
    public function testValidateUpdatePasswordEmptyNewPasswordRepeat()
    {
        $profile = Profile::findByUsername('imtester');
        $profile->scenario = $profile::SCENARIO_PASSWORD_UPDATE;
        $profile->newPassword = '123456';
        $profile->newPasswordRepeat = '';
        $profile->currentPassword = 'password_0';
        expect_not($profile->validate());
    }

    /**
     * @inheritdoc
     */
    public function testValidateUpdatePasswordWrongCompare()
    {
        $profile = Profile::findByUsername('imtester');
        $profile->scenario = $profile::SCENARIO_PASSWORD_UPDATE;
        $profile->newPassword = '123456';
        $profile->newPasswordRepeat = '654321';
        $profile->currentPassword = 'password_0';
        expect_not($profile->validate());
    }

    /**
     * @inheritdoc
     */
    public function testValidateUpdatePasswordWrongCurrent()
    {
        $profile = Profile::findByUsername('imtester');
        $profile->scenario = $profile::SCENARIO_PASSWORD_UPDATE;
        $profile->newPassword = '123456';
        $profile->newPasswordRepeat = '123456';
        $profile->currentPassword = 'wrong_password';
        expect_not($profile->validate());
    }

    /**
     * @inheritdoc
     */
    public function testValidateUpdatePasswordSuccess()
    {
        $profile = Profile::findByUsername('imtester');
        $profile->scenario = $profile::SCENARIO_PASSWORD_UPDATE;
        $profile->newPassword = '123456';
        $profile->newPasswordRepeat = '123456';
        $profile->currentPassword = 'password_0';
        expect_that($profile->validate());
    }
}
