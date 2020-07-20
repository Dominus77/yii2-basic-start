<?php

namespace functional;

use Yii;
use FunctionalTester;

/**
 * Class HomeCest
 * @package functional
 */
class HomeCest
{
    /**
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
