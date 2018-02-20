<?php

namespace modules\main\models;

use Yii;
use yii\base\Model;
use yii\helpers\Url;
use modules\main\Module;

/**
 * Class ContactForm
 * @package modules\main\models
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;

    const SCENARIO_GUEST = 'guest';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'required', 'on' => self::SCENARIO_GUEST],
            ['verifyCode', 'captcha', 'captchaAction' => Url::to('/main/default/captcha'), 'on' => self::SCENARIO_GUEST],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => Module::t('module', 'Name'),
            'email' => Module::t('module', 'Email'),
            'subject' => Module::t('module', 'Subject'),
            'body' => Module::t('module', 'Body'),
            'verifyCode' => Module::t('module', 'Verification Code'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }
}
