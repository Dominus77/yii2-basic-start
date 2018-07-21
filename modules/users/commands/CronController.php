<?php

namespace modules\users\commands;

use modules\users\models\User;
use yii\console\Controller;
use app\components\helpers\Console;
use Yii;
use modules\users\Module;

/**
 * Console crontab actions
 */
class CronController extends Controller
{
    /**
     * @var \modules\users\Module
     */
    public $module;

    /**
     * Removes non-activated expired users
     */
    public function actionRemoveOverdue()
    {
        foreach (User::find()->overdue($this->module->emailConfirmTokenExpire)->each() as $user) {
            /** @var User $user */
            $this->stdout($user->username);
            if ($user->delete() !== false) {
                Yii::info(Console::convertEncoding(Module::t('module', 'Remove expired users {:Username}', [':Username' => $user->username])));
                $this->stdout(Console::convertEncoding(Module::t('module', 'OK')), Console::FG_GREEN, Console::BOLD);
            } else {
                Yii::warning(Console::convertEncoding(Module::t('module', 'Cannot remove expired users {:Username}', [':Username' => $user->username])));
                $this->stderr(Console::convertEncoding(Module::t('module', 'Fail!')), Console::FG_RED, Console::BOLD);
            }
            $this->stdout(PHP_EOL);
        }

        $this->stdout(Console::convertEncoding(Module::t('module', 'Done!')), Console::FG_GREEN, Console::BOLD);
        $this->stdout(PHP_EOL);
    }
}
