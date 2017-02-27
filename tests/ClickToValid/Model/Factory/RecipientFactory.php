<?php

namespace ClickToValid\Tests\Model\Factory;

use ClickToValid\Exception\AbstractException;
use ClickToValid\Exception\RecipientAnswerDateNotValidException;
use ClickToValid\Model\Factory\RecipientFactory;
use ClickToValid\Model\Recipient;
use ClickToValid\Model\User;

class RecipientFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        $data      = json_decode(json_encode([
            'id'          => 'bbd9fe0d-c184-4df4-90c8-6d8396728dbf',
            'answer'      => true,
            'data_answer' => '2017-02-01T09:00:00+00:00',
            'receiver'    => [
                'data' => [
                    'id'        => '8233f750-8281-41d0-bf55-3a0bb9e661ce',
                    'username'  => 'JohnDoe',
                    'email'     => 'johndoe@mycompany.com',
                    'firstname' => 'John',
                    'lastname'  => 'Doe',
                ],
            ],
        ]));
        $recipient = RecipientFactory::parseData($data);

        // Tests a Recipient is returned
        $this->assertInstanceOf(Recipient::class, $recipient);

        // Tests Recipient fields are well hydrated
        $this->assertEquals('bbd9fe0d-c184-4df4-90c8-6d8396728dbf', $recipient->getId());
        $this->assertTrue($recipient->getAnswer());
        $this->assertInstanceOf(\DateTime::class, $recipient->getDateAnswer());
        $this->assertEquals(1485939600, $recipient->getDateAnswer()->getTimestamp());

        // Tests Recipient relation field "receiver" is hydrated and has expected value
        $this->assertInstanceOf(User::class, $recipient->getReceiver());
        $this->assertEquals('8233f750-8281-41d0-bf55-3a0bb9e661ce', $recipient->getReceiver()->getId());

        // Tests an exception is thrown if date_answer not well formatted
        $data->date_answer = '2017-02-not-well-formattedT09:00:00+00:00';
        $exception         = false;

        try {
            $recipient = RecipientFactory::parseData($data);
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(RecipientAnswerDateNotValidException::class, $e);
        }
        $this->assertTrue($exception);
    }
}
