<?php

use app\fixtures\User as UserFixture;

class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'login_data.php'
            ]
        ]);
        $I->amOnRoute('/user/default/login');
    }

    /**
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
     * @param FunctionalTester $I
     */
    public function checkEmpty(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');
    }

    /**
     * @param FunctionalTester $I
     */
    public function checkWrongPassword(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('admin@email.loc', 'wrong'));
        $I->see('Invalid email or password.');
    }

    /**
     * @param FunctionalTester $I
     */
    public function checkValidLogin(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('sfriesen@jenkins.info', 'password_0'));
        //$I->see('Profile (erau)', 'a'); // TODO: когда будет создана страница профиля
        $I->dontSeeLink('Login');
        $I->dontSeeLink('Signup');
    }
}
