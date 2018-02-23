<?php

namespace tests\models;

use app\fixtures\User as UserFixture;
use modules\users\models\ResetPasswordForm;

/**
 * Class ResetPasswordFormTest
 * @package tests\models
 */
class ResetPasswordFormTest extends \Codeception\Test\Unit
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
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function testResetWrongToken()
    {
        $this->tester->expectException('yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectException('yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    /**
     * @inheritdoc
     */
    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('users', 2);
        $form = new ResetPasswordForm($user['password_reset_token']);
        expect_that($form->resetPassword());
    }
}
