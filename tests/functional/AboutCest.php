<?php

namespace functional;

use FunctionalTester;

/**
 * Class AboutCest
 * @package functional
 */
class AboutCest
{
    /**
     * @param FunctionalTester $I
     */
    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnRoute('main/default/about');
        $I->see('About', 'h1');
    }
}
