<?php

use app\fixtures\User as UserFixture;

/**
 * Class LoginFormCest
 */
class LoginFormCest
{
    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function _before(\FunctionalTester $I)
    {
        $I->haveFixtures([
            'users' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ]);
        $I->amOnRoute('/users/default/login');
    }

    /**
     * @inheritdoc
     * @param $email
     * @param $password
     * @return array
     */
    protected function formParams($email, $password)
    {
        return [
            'LoginForm[email]' => $email,
            'LoginForm[password]' => $password,
        ];
    }

    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function checkEmpty(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function checkWrongPassword(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin@email.loc', 'wrong'));
        $I->see('Invalid email or password.');
    }

    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function checkValidLogin(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('sfriesen@jenkins.info', 'password_0'));
        $I->see('Profile (erau)', 'a');
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
