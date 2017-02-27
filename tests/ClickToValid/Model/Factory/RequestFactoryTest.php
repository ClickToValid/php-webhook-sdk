<?php

namespace ClickToValid\Tests\Model\Factory;

use ClickToValid\Exception\AbstractException;
use ClickToValid\Exception\RequestExpirationDateNotValidException;
use ClickToValid\Exception\RequestSentDateNotValidException;
use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Model\File;
use ClickToValid\Model\Recipient;
use ClickToValid\Model\Request;
use ClickToValid\Model\User;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        $data    = json_decode(json_encode([
            'id'              => 'ca52d6ff-259f-4b02-b11e-11d72af4d111',
            'name'            => 'CTV-8',
            'topic'           => 'Lorem ipsum',
            'has_message'     => true,
            'state'           => 'sent',
            'date_expiration' => '2017-02-01T09:00:00+00:00',
            'date_sent'       => '2017-01-01T09:00:00+00:00',
            'sender'          => [
                'data' => [
                    'id'        => '8233f750-8281-41d0-bf55-3a0bb9e661ce',
                    'username'  => 'JohnDoe',
                    'email'     => 'johndoe@mycompany.com',
                    'firstname' => 'John',
                    'lastname'  => 'Doe',
                ],
            ],
            'recipients'      => [
                'data' => [
                    [
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
                    ],
                ],
            ],
            'files'           => [
                'data' => [
                    [
                        'id'        => 'c74d2879-379b-4b69-95c5-deb16eae2063',
                        'filename'  => 'my-file.jpg',
                        'size'      => 565,
                        'extension' => 'jpg',
                        'mimetype'  => 'image/jpeg',
                    ],
                ],
            ],
        ]));
        $request = RequestFactory::parseData($data);

        // Tests a Request is returned
        $this->assertInstanceOf(Request::class, $request);

        // Tests Request fields are well hydrated
        $this->assertEquals('ca52d6ff-259f-4b02-b11e-11d72af4d111', $request->getId());
        $this->assertEquals('CTV-8', $request->getName());
        $this->assertEquals('Lorem ipsum', $request->getTopic());
        $this->assertTrue($request->getHasMessage());
        $this->assertEquals('sent', $request->getState());
        $this->assertInstanceOf(\DateTime::class, $request->getDateExpiration());
        $this->assertEquals(1485939600, $request->getDateExpiration()->getTimestamp());
        $this->assertInstanceOf(\DateTime::class, $request->getDateSent());
        $this->assertEquals(1483261200, $request->getDateSent()->getTimestamp());

        // Tests Recipient relation field "sender" is hydrated and has expected value
        $this->assertInstanceOf(User::class, $request->getSender());
        $this->assertEquals('8233f750-8281-41d0-bf55-3a0bb9e661ce', $request->getSender()->getId());

        // Tests Request relation field "recipients" is hydrated and has expected value
        $this->assertTrue(is_array($request->getRecipients()));
        $this->assertCount(1, $request->getRecipients()); // 1 recipient
        $this->assertInstanceOf(Recipient::class, $request->getRecipients()[0]);
        $this->assertEquals('bbd9fe0d-c184-4df4-90c8-6d8396728dbf', $request->getRecipients()[0]->getId());

        // Tests Request relation field "files" is hydrated and has expected value
        $this->assertTrue(is_array($request->getFiles()));
        $this->assertCount(1, $request->getFiles()); // 1 file
        $this->assertInstanceOf(File::class, $request->getFiles()[0]);
        $this->assertEquals('c74d2879-379b-4b69-95c5-deb16eae2063', $request->getFiles()[0]->getId());

        // Tests when not valid date_expiration
        $data2                  = clone $data;
        $data2->date_expiration = '2017-02-not-well-formattedT09:00:00+00:00';
        $exception              = false;

        try {
            $request = RequestFactory::parseData($data2);
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(RequestExpirationDateNotValidException::class, $e);
        }
        $this->assertTrue($exception);

        // Tests when not valid date_sent
        $data3            = clone $data;
        $data3->date_sent = '2017-02-not-well-formattedT09:00:00+00:00';
        $exception        = false;

        try {
            $request = RequestFactory::parseData($data3);
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(RequestSentDateNotValidException::class, $e);
        }
        $this->assertTrue($exception);
    }
}
