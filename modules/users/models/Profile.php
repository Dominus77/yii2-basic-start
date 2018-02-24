<?php

namespace modules\users\models;

use yii\helpers\ArrayHelper;
use modules\users\traits\ModuleTrait;
use modules\users\Module;

/**
 * Class Profile
 * @package modules\users\models
 *
 * This is the model class extends User.
 *
 * @property string $username Username
 * @property string $currentPassword Current Password
 * @property string $newPassword New Password
 * @property string $newPasswordRepeat Repeat New Password
 * @property string $email Email
 * @property string $first_name First Name
 * @property string $last_name Last Name
 */
class Profile extends User
{
    use ModuleTrait;

    /**
     * Scenarios
     */
    const SCENARIO_PASSWORD_UPDATE = 'updatePassword';

    /**
     * @var string
     */
    public $currentPassword;

    /**
     * @var string
     */
    public $newPassword;

    /**
     * @var string
     */
    public $newPasswordRepeat;

    /**
     * @inheritdoc
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::class, 'message' => Module::t('module', 'This username is already taken.')],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::class, 'message' => Module::t('module', 'This email is already taken.')],
            ['email', 'string', 'max' => 255],

            ['first_name', 'string', 'max' => 45],
            ['last_name', 'string', 'max' => 45],

            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required', 'on' => [self::SCENARIO_PASSWORD_UPDATE]],
            ['newPassword', 'string', 'min' => self::LENGTH_STRING_PASSWORD_MIN, 'max' => self::LENGTH_STRING_PASSWORD_MAX],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword', 'on' => [self::SCENARIO_PASSWORD_UPDATE]],
            ['currentPassword', 'validateCurrentPassword', 'skipOnEmpty' => false, 'skipOnError' => false, 'on' => [self::SCENARIO_PASSWORD_UPDATE]],
        ];
    }

    /**
     * @param string $attribute
     */
    public function validateCurrentPassword($attribute)
    {
        if (!empty($this->newPassword) && !empty($this->newPasswordRepeat) && !$this->hasErrors()) {
            $this->processValidatePassword($attribute);
        } else {
            $this->addError($attribute, Module::t('module', 'Not all fields are filled in correctly.'));
        }
    }

    /**
     * @param string $attribute
     */
    public function processValidatePassword($attribute)
    {
        if ($attribute) {
            if (!$this->validatePassword($this->$attribute))
                $this->addError($attribute, Module::t('module', 'Incorrect current password.'));
        } else {
            $this->addError($attribute, Module::t('module', 'Enter your current password.'));
        }
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'currentPassword' => Module::t('module', 'Current Password'),
            'newPassword' => Module::t('module', 'New Password'),
            'newPasswordRepeat' => Module::t('module', 'Repeat Password'),
        ]);
    }

    /**
     * Actions before saving
     *
     * @param bool $insert
     * @return bool
     * @throws \yii\base\Exception
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->newPassword)) {
                $this->setPassword($this->newPassword);
            }
            return true;
        }
        return false;
    }
}
