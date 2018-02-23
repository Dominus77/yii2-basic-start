<?php

namespace tests\models;

use Yii;
use modules\users\models\PasswordResetRequestForm;
use app\fixtures\User as UserFixture;
use modules\users\models\User;

/**
 * Class PasswordResetRequestFormTest
 * @package tests\models
 */
class PasswordResetRequestFormTest extends \Codeception\Test\Unit
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
    public function testSendMessageWithWrongEmailAddress()
    {
        $model = new PasswordResetRequestForm();
        $model->email = 'not-existing-email@example.com';
        expect_not($model->sendEmail());
    }

    /**
     * @inheritdoc
     */
    public function testNotSendEmailsToInactiveUser()
    {
        $user = $this->tester->grabFixture('users', 1);
        $model = new PasswordResetRequestForm();
        $model->email = $user['email'];
        expect_not($model->sendEmail());
    }

    /**
     * @inheritdoc
     */
    public function testSendEmailSuccessfully()
    {
        $userFixture = $this->tester->grabFixture('users', 2);

        $model = new PasswordResetRequestForm();
        $model->email = $userFixture['email'];
        $user = User::findOne(['password_reset_token' => $userFixture['password_reset_token']]);

        expect_that($model->sendEmail());
        expect_that($user->password_reset_token);

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey($model->email);
        expect($emailMessage->getFrom())->hasKey(Yii::$app->params['supportEmail']);
    }
}
