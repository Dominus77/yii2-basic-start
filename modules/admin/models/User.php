<?php

namespace modules\admin\models;

use yii\helpers\ArrayHelper;
use modules\admin\Module;

/**
 * Class User
 * @package modules\admin\models
 */
class User extends \modules\users\models\User
{
    /**
     * @var string
     */
    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
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

            ['registration_type', 'safe'],

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],

            [['password'], 'required'],
        ]);
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
}
