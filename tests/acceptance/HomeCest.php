<?php

use yii\helpers\Url;

/**
 * Class HomeCest
 */
class HomeCest
{
    /**
     * @inheritdoc
     * @param AcceptanceTester $I
     */
    public function ensureThatHomePageWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/main/default/index'));
        $I->see('Yii2-basic-start');
        
        $I->seeLink('About');
        $I->click('About');
        $I->wait(2); // wait for page to be opened
        
        $I->see('This is the About page.');
    }
}
