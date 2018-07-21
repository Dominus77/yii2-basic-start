<?php

namespace modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;
use modules\admin\Module;

/**
 * Class User
 * @package modules\admin\models
 *
 * @property string $password Password
 */
class User extends \modules\users\models\User
{
    const SCENARIO_ADMIN_CREATE = 'adminCreate';

    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'email', 'status'], 'required'],
            [['password'], 'required', 'on' => [self::SCENARIO_ADMIN_CREATE]],

            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::class, 'message' => Module::t('users', 'This username is already taken.'), 'on' => [self::SCENARIO_ADMIN_CREATE]],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::class, 'message' => Module::t('users', 'This email is already taken.'), 'on' => [self::SCENARIO_ADMIN_CREATE]],
            ['email', 'string', 'max' => 255],

            [['first_name', 'last_name'], 'string', 'max' => 45],

            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            ['password', 'string', 'min' => self::LENGTH_STRING_PASSWORD_MIN, 'max' => self::LENGTH_STRING_PASSWORD_MAX],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'password' => Module::t('users', 'Password'),
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
            if (!empty($this->password)) {
                $this->setPassword($this->password);
            }
            return true;
        }
        return false;
    }
}
