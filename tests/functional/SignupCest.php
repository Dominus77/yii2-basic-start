<?php

/**
 * Class SignupCest
 */
class SignupCest
{
    /**
     * @var string
     */
    protected $formId = '#form-signup';

    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/users/default/signup');
    }

    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see('Check in', 'h1');
        $I->see('Please fill in the following fields to sign up:');
        $I->submitForm($this->formId, []);
        $I->see('Username cannot be blank.');
        $I->see('Email cannot be blank.');
        $I->see('Password cannot be blank.');

    }

    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
            'SignupForm[username]'  => 'tester',
            'SignupForm[email]'     => 'ttttt',
            'SignupForm[password]'  => 'tester_password',
        ]
        );
        $I->dontSee('Username cannot be blank.', '.help-block');
        $I->dontSee('Password cannot be blank.', '.help-block');
        $I->see('Email is not a valid email address.', '.help-block');
    }

    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'testers',
            'SignupForm[email]' => 'testers@example.com',
            'SignupForm[password]' => '123456',
        ]);

        $I->see('It remains to activate the account, check your mail.');
    }
}
