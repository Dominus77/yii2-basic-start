<?php

namespace modules\users\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use modules\users\traits\ModuleTrait;
use modules\users\Module;

/**
 * Class IdentityUser
 * @package modules\users\models
 *
 * This is the model class for table "{{%users}}".
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
 * @property array statusesArray Array statuses
 * @property string $authKey
 */
class IdentityUser extends ActiveRecord implements IdentityInterface
{
    use ModuleTrait;

    /**
     * Length password symbols min
     */
    const LENGTH_STRING_PASSWORD_MIN = 6;

    /**
     * Length password symbols max
     */
    const LENGTH_STRING_PASSWORD_MAX = 16;

    /**
     * Users Statuses
     */
    const STATUS_BLOCKED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_WAIT = 2;
    const STATUS_DELETED = 3;

    /**
     * @inheritdoc
     * @return string
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
            ],
        ];
    }

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

            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => array_keys(self::getStatusesArray())],
        ];
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => Module::t('module', 'Created'),
            'updated_at' => Module::t('module', 'Updated'),
            'last_visit' => Module::t('module', 'Last Visit'),
            'username' => Module::t('module', 'Username'),
            'email' => Module::t('module', 'Email'),
            'auth_key' => Module::t('module', 'Auth Key'),
            'status' => Module::t('module', 'Status'),
            'first_name' => Module::t('module', 'First Name'),
            'last_name' => Module::t('module', 'Last Name'),
            'email_confirm_token' => Module::t('module', 'Email Confirm Token'),
            'password_reset_token' => Module::t('module', 'Password Reset Token'),
            'password_hash' => Module::t('module', 'Password Hash'),
        ];
    }

    /**
     * @param int|string $id
     * @return IdentityInterface
     */
    public static function findIdentity($id)
    {
        /** @var  IdentityInterface $result */
        $result = static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
        return $result;
    }

    /**
     * @param mixed $token
     * @param null|mixed $type
     * @return IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /** @var  IdentityInterface $result */
        $result = static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
        return $result;
    }

    /**
     * @return string|integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current users auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string|mixed $authKey
     * @return boolean if auth key is valid for current users
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @return array
     */
    public static function getStatusesArray()
    {
        return [
            self::STATUS_BLOCKED => Module::t('module', 'Blocked'),
            self::STATUS_ACTIVE => Module::t('module', 'Active'),
            self::STATUS_WAIT => Module::t('module', 'Wait'),
            self::STATUS_DELETED => Module::t('module', 'Deleted'),
        ];
    }
}
