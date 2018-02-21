<?php

/**
 * Class AboutCest
 */
class AboutCest
{
    /**
     * @inheritdoc
     * @param FunctionalTester $I
     */
    public function checkAbout(FunctionalTester $I)
    {
        $I->amOnRoute('main/default/about');
        $I->see('About', 'h1');
    }
}
