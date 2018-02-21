<?php

use yii\helpers\Url;

/**
 * Class AboutCest
 */
class AboutCest
{
    /**
     * @inheritdoc
     * @param AcceptanceTester $I
     */
    public function ensureThatAboutWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/main/default/about'));
        $I->see('About', 'h1');
    }
}
