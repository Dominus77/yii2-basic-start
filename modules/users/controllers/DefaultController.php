<?php

namespace modules\users\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use modules\users\models\LoginForm;
use modules\users\models\PasswordResetRequestForm;
use modules\users\models\ResetPasswordForm;
use modules\users\models\SignupForm;
use modules\users\models\EmailConfirmForm;
use modules\users\Module;

/**
 * Class DefaultController
 * @package modules\users\controllers
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Requests password reset.
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                return $this->processGoHome(Module::t('module', 'To the address {:Email} We sent you a letter with further instructions, check mail.', [':Email' => $model->email]));
            } else {
                Yii::$app->session->setFlash('error', Module::t('module', 'Sorry, we are unable to reset password.'));
            }
        }
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $message
     * @param string $type
     * @return \yii\web\Response
     */
    public function processGoHome($message = '', $type = 'success')
    {
        if (!empty($message)) {
            Yii::$app->session->setFlash($type, $message);
        }
        return $this->goHome();
    }
    
    /**
     * Resets password.
     *
     * @param string $token
     * @return string|Response
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $this->processResetPassword($model)) {
            return $this->processGoHome(Module::t('module', 'The new password was successfully saved.'));
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param ResetPasswordForm $model
     * @return bool
     * @throws \yii\base\Exception
     */
    public function processResetPassword($model)
    {
        if ($model->validate() && $model->resetPassword()) {
            return true;
        }
        return false;
    }

    /**
     * Signs users up.
     *
     * @return string|Response
     * @throws \yii\base\Exception
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                return $this->processGoHome(Module::t('module', 'It remains to activate the account, check your mail.'));
            }
        }
        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $token
     * @return Response
     * @throws BadRequestHttpException
     * @throws \Exception
     */
    public function actionEmailConfirm($token)
    {
        try {
            $model = new EmailConfirmForm($token);
        } catch (\InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->confirmEmail()) {
            return $this->processGoHome(Module::t('module', 'Thank you for registering! Now you can log in using your credentials.'));
        }
        return $this->processGoHome(Module::t('module', 'Error sending message!'), 'error');
    }
}
