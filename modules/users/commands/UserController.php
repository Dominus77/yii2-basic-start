<?php

namespace modules\users\commands;

use Yii;
use modules\users\models\User;
use yii\console\Controller;
use yii\console\Exception;
use app\components\helpers\Console;
use modules\users\Module;

/**
 * Class UsersController
 * @package app\modules\users\commands
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        echo 'yii users/users/create' . PHP_EOL;
        echo 'yii users/users/remove' . PHP_EOL;
        echo 'yii users/users/activate' . PHP_EOL;
        echo 'yii users/users/change-password' . PHP_EOL;
    }

    /**
     * @inheritdoc
     */
    public function actionCreate()
    {
        $model = new User();
        $this->readValue($model, 'username');
        $this->readValue($model, 'email');
        $model->setPassword($this->prompt(Console::convertEncoding(Module::t('module', 'Password:')), [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => Console::convertEncoding(Module::t('module', 'More than 6 symbols')),
        ]));
        $model->generateAuthKey();
        if (($select = Console::convertEncoding(User::getStatusesArray())) && is_array($select)) {
            $model->status = $this->select(Console::convertEncoding(Module::t('module', 'Status:')), $select);
            $this->log($model->save());
        } else {
            $this->log();
        }
    }

    /**
     * @throws Exception
     * @throws \Exception
     * @throws \Throwable
     */
    public function actionRemove()
    {
        $username = $this->prompt(Console::convertEncoding(Module::t('module', 'Username:')), ['required' => true]);
        $model = $this->findModel($username);
        if ($model->delete() !== false) {
            $this->log(true);
        } else {
            $this->log(false);
        }
    }

    /**
     * @throws Exception
     */
    public function actionActivate()
    {
        $username = $this->prompt(Console::convertEncoding(Module::t('module', 'Username:')), ['required' => true]);
        $model = $this->findModel($username);
        $model->status = User::STATUS_ACTIVE;
        $model->removeEmailConfirmToken();
        $this->log($model->save());
    }

    /**
     * @throws Exception
     * @throws \yii\base\Exception
     */
    public function actionChangePassword()
    {
        $username = $this->prompt(Console::convertEncoding(Module::t('module', 'Username:')), ['required' => true]);
        $model = $this->findModel($username);
        $model->setPassword($this->prompt(Console::convertEncoding(Module::t('module', 'New password:')), [
            'required' => true,
            'pattern' => '#^.{6,255}$#i',
            'error' => Console::convertEncoding(Module::t('module', 'More than 6 symbols')),
        ]));
        $this->log($model->save());
    }

    /**
     * @param string $username
     * @throws \yii\console\Exception
     * @return User the loaded model
     */
    private function findModel($username)
    {
        if (!$model = User::findOne(['username' => $username])) {
            throw new Exception(
                Console::convertEncoding(
                    Module::t('module', 'User "{:Username}" not found', [':Username' => $username])
                )
            );
        }
        return $model;
    }

    /**
     * @param \yii\base\Model $model
     * @param string $attribute
     */
    private function readValue($model = null, $attribute = '')
    {
        $model->$attribute = $this->prompt(Console::convertEncoding(Module::t('module', mb_convert_case($attribute, MB_CASE_TITLE, 'UTF-8') . ':')), [
            'validator' => function ($input, &$error) use ($model, $attribute) {
                /** @var string $input */
                $model->$attribute = $input;
                /** @var \yii\base\Model $model */
                if ($model->validate([$attribute])) {
                    return true;
                } else {
                    $error = Console::convertEncoding(implode(',', $model->getErrors($attribute)));
                    return false;
                }
            },
        ]);
    }

    /**
     * @param bool|int $success
     */
    private function log($success = false)
    {
        if ($success === true || $success !== 0) {
            $this->stdout(Console::convertEncoding(Module::t('module', 'Success!')), Console::FG_GREEN, Console::BOLD);
        } else {
            $this->stderr(Console::convertEncoding(Module::t('module', 'Error!')), Console::FG_RED, Console::BOLD);
        }
        echo PHP_EOL;
    }
}
