<?php

namespace tests\models;

use modules\main\models\ContactForm;

/**
 * Class ContactFormTest
 * @package tests\models
 */
class ContactFormTest extends \Codeception\Test\Unit
{
    /**
     * @var ContactForm
     */
    private $model;

    /**
     * @var \UnitTester
     */
    public $tester;

    /**
     * @inheritdoc
     */
    public function testEmailIsSentOnContact()
    {
        $this->model = $this->getMockBuilder('modules\main\models\ContactForm')
            ->onlyMethods(['validate'])
            ->getMock();

        $this->model->expects($this->once())
            ->method('validate')
            ->will($this->returnValue(true));

        $this->model->attributes = [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'subject' => 'very important letter subject',
            'body' => 'body of current message',
        ];

        expect_that($this->model->contact('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();
        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('tester@example.com');
        expect($emailMessage->getSubject())->equals('very important letter subject');
        expect($emailMessage->toString())->stringContainsString('body of current message');
    }
}
