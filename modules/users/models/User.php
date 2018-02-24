<?php

namespace modules\users\models;

use Yii;
use yii\helpers\ArrayHelper;
use modules\users\models\query\UserQuery;
use modules\users\traits\ModuleTrait;
use modules\users\Module;

/**
 * Class User
 * @package modules\users\models
 *
 * This is the model class extends BaseUser.
 *
 * @property int $id ID
 * @property string $username Username
 * @property string $auth_key Authorization Key
 * @property string $password_hash Hash Password
 * @property string $password_reset_token Password Token
 * @property string $email_confirm_token Email Confirm Token
 * @property string $email Email
 * @property int|string $status Status
 * @property int $last_visit Last Visit
 * @property int $created_at Created
 * @property int $updated_at Updated
 * @property string $first_name First Name
 * @property string $last_name Last Name
 * @property int $registration_type Type Registration
 * @property string statusLabelName Status name in label
 * @property array statusesArray Array statuses
 * @property string statusName Name status
 * @property int|string registrationType Type registered
 */
class User extends BaseUser
{
    use ModuleTrait;

    /**
     * @return object|\yii\db\ActiveQuery
     * @throws \yii\base\InvalidConfigException
     */
    public static function find()
    {
        return Yii::createObject(UserQuery::class, [get_called_class()]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByUsernameEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username or email
     *
     * @param string $string
     * @return static|null
     * @throws \yii\base\InvalidConfigException
     */
    public static function findByUsernameOrEmail($string)
    {
        return static::find()
            ->where(['or', ['username' => $string], ['email' => $string]])
            ->andWhere(['status' => self::STATUS_ACTIVE])
            ->one();
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Removes email confirmation token
     */
    public function removeEmailConfirmToken()
    {
        $this->email_confirm_token = null;
    }

    /**
     * Finds user by password reset token
     *
     * @param mixed $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }
        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * @param mixed $email_confirm_token
     * @return bool|null|static
     */
    public static function findByEmailConfirmToken($email_confirm_token)
    {
        return static::findOne([
            'email_confirm_token' => $email_confirm_token,
            'status' => self::STATUS_WAIT
        ]);
    }

    /**
     * Generates email confirmation token
     */
    public function generateEmailConfirmToken()
    {
        $this->email_confirm_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Type of registration
     * How the user is created
     * If the system registration type is registered by itself,
     * if it is created from the admin area,
     * then the login type that created the account
     *
     * @return mixed|string
     */
    public function getRegistrationType()
    {
        if ($this->registration_type > 0) {
            if (($model = User::findOne($this->registration_type)) !== null) {
                return $model->username;
            }
        }
        return $this->getRegistrationTypeName();
    }

    /**
     * Returns the registration type string
     * @return mixed
     */
    public function getRegistrationTypeName()
    {
        return ArrayHelper::getValue(self::getRegistrationTypesArray(), $this->registration_type);
    }

    /**
     * Returns an array of log types
     * @return array
     */
    public static function getRegistrationTypesArray()
    {
        return [
            self::TYPE_REGISTRATION_SYSTEM => Module::t('module', 'System'),
        ];
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->id === 1; // Super admin id=1
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return $this->status === self::STATUS_DELETED;
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param mixed $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['users.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * Set Status
     * @return int|string
     */
    public function setStatus()
    {
        switch ($this->status) {
            case self::STATUS_ACTIVE:
                $this->status = self::STATUS_BLOCKED;
                break;
            case self::STATUS_DELETED:
                $this->status = self::STATUS_WAIT;
                break;
            default:
                $this->status = self::STATUS_ACTIVE;
        }
        return $this->status;
    }
}
