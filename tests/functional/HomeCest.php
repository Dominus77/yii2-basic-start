<?php

/**
 * Class HomeCest
 */
class HomeCest
{
    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(Yii::$app->homeUrl);
        $I->see('My Application');
        $I->seeLink('About');
        $I->click('About');
        $I->see('This is the About page.');
    }
}
