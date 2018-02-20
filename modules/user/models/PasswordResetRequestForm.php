<?php

namespace modules\user\models;

use Yii;
use yii\base\Model;
use modules\user\Module;

/**
 * Class PasswordResetRequestForm
 * @package modules\user\models
 *
 * @property string $email Email
 */
class PasswordResetRequestForm extends Model
{
    public $email;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\modules\user\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => Module::t('module', 'There is no user with this e-mail.'),
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return bool whether the email was send
     */
    public function sendEmail()
    {

        if ($user = $this->getUser()) {
            return Yii::$app->mailer->compose(
                ['html' => '@modules/user/mail/passwordResetToken-html', 'text' => '@modules/user/mail/passwordResetToken-text'],
                ['user' => $user])
                ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                ->setTo($this->email)
                ->setSubject(Module::t('module', 'Password reset for') . ' ' . Yii::$app->name)
                ->send();
        }
        return false;
    }

    /**
     * @return bool|User
     */
    private function getUser()
    {
        /* @var $user \modules\user\models\User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user === null) {
            return false;
        }

        if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                return false;
            }
        }
        return $user;
    }
}
