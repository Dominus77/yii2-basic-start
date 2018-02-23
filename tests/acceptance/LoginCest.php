<?php

use yii\helpers\Url;

/**
 * Class LoginCest
 */
class LoginCest
{
    /**
     * @inheritdoc
     * @param AcceptanceTester $I
     */
    public function ensureThatLoginWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/users/default/login'));
        $I->see('Login', 'h1');

        $I->amGoingTo('try to login with correct credentials');
        $I->fillField('input[name="LoginForm[username]"]', 'admin');
        $I->fillField('input[name="LoginForm[password]"]', 'admin');
        $I->click('login-button');
        $I->wait(2); // wait for button to be clicked

        $I->expectTo('see users info');
        $I->see('Logout');
    }
}
