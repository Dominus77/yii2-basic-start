<?php

namespace modules\admin\models;

use Yii;
use yii\helpers\ArrayHelper;
use modules\admin\Module;

/**
 * Class User
 * @package modules\admin\models
 *
 * @property $password string
 */
class User extends \modules\users\models\User
{
    /**
     * @var string
     */
    public $password;

    const SCENARIO_ADMIN_CREATE = 'adminCreate';

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'match', 'pattern' => '#^[\w_-]+$#i'],
            ['username', 'unique', 'targetClass' => self::class, 'message' => Module::t('module', 'This username is already taken.'), 'on' => [self::SCENARIO_ADMIN_CREATE]],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => self::class, 'message' => Module::t('module', 'This email is already taken.'), 'on' => [self::SCENARIO_ADMIN_CREATE]],
            ['email', 'string', 'max' => 255],

            ['first_name', 'string', 'max' => 45],
            ['last_name', 'string', 'max' => 45],

            ['registration_type', 'safe'],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            [['password'], 'required', 'on' => [self::SCENARIO_ADMIN_CREATE]],
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
                $this->registration_type = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }
}
