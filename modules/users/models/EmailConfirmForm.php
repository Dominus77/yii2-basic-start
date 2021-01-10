<?php

namespace modules\users\models;

use Exception;
use yii\base\InvalidArgumentException;
use yii\base\Model;
use modules\users\Module;
use yii\rbac\Assignment;

/**
 * Class EmailConfirmForm
 * @package modules\users\models\frontend
 */
class EmailConfirmForm extends Model
{
    /**
     * @var User|bool
     */
    private $user;

    /**
     * Creates a form model given a token.
     *
     * @param  mixed $token
     * @param  array $config
     * @throws InvalidArgumentException if token is empty or not valid
     */
    public function __construct($token = '', $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException(Module::t(
                'module',
                'Email confirm token cannot be blank.'
            ));
        }
        $this->user = User::findByEmailConfirmToken($token);
        if (!$this->user) {
            throw new InvalidArgumentException(Module::t('module', 'Wrong Email confirm token.'));
        }
        parent::__construct($config);
    }

    /**
     * Confirm email.
     *
     * @return bool|Assignment if email was confirmed.
     * @throws Exception
     */
    public function confirmEmail()
    {
        $user = $this->user;
        $user->status = User::STATUS_ACTIVE;
        $user->removeEmailConfirmToken();
        if ($user->save(false)) {
            return true;
        }
        return false;
    }
}
