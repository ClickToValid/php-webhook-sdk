<?php

namespace ClickToValid\Tests;

use ClickToValid\Exception\AbstractException;
use ClickToValid\Exception\NotValidJsonException;
use ClickToValid\Exception\WebhookNoDataFoundException;
use ClickToValid\Exception\WebhookTypeMissingException;
use ClickToValid\Exception\WebhookTypeNotManagedException;
use ClickToValid\Manager;
use ClickToValid\Webhook\FileViewedWebhook;
use ClickToValid\Webhook\RecipientAnsweredWebhook;
use ClickToValid\Webhook\RequestExpiredWebhook;
use ClickToValid\Webhook\RequestFullyAnsweredWebhook;
use ClickToValid\Webhook\RequestManualRevivedWebhook;
use ClickToValid\Webhook\RequestOpenedWebhook;
use ClickToValid\Webhook\RequestSentWebhook;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        // Tests when not JSON, NotValidJsonException thrown
        $exception = false;
        try {
            Manager::parseData('Not valid JSON');
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(NotValidJsonException::class, $e);
        }
        $this->assertTrue($exception);

        // Tests when no type given, WebhookTypeMissingException thrown
        $exception = false;
        try {
            Manager::parseData('{"date":"2017-02-01T09:00:00+00:00","data":{}}');
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(WebhookTypeMissingException::class, $e);
        }
        $this->assertTrue($exception);

        // Tests when no type given, WebhookTypeNotManagedException thrown
        $exception = false;
        try {
            Manager::parseData('{"type":"not-managed-type","date":"2017-02-01T09:00:00+00:00","data":{}}');
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(WebhookTypeNotManagedException::class, $e);
        }
        $this->assertTrue($exception);

        // Tests when no data field, WebhookNoDataFoundException thrown
        $exception = false;
        try {
            Manager::parseData('{"date":"2017-02-01T09:00:00+00:00","type":"file-viewed"}');
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(WebhookNoDataFoundException::class, $e);
        }
        $this->assertTrue($exception);

        // Tests expected Webhooks returned for given types
        $this->assertInstanceOf(FileViewedWebhook::class, Manager::parseData('{"type":"'.Manager::TYPE_FILE_VIEWED.'","date":"2017-02-01T09:00:00+00:00","data":{}}'));
        $this->assertInstanceOf(RecipientAnsweredWebhook::class, Manager::parseData('{"type":"'.Manager::TYPE_RECIPIENT_ANSWERED.'","date":"2017-02-01T09:00:00+00:00","data":{}}'));
        $this->assertInstanceOf(RequestExpiredWebhook::class, Manager::parseData('{"type":"'.Manager::TYPE_REQUEST_EXPIRED.'","date":"2017-02-01T09:00:00+00:00","data":{}}'));
        $this->assertInstanceOf(RequestFullyAnsweredWebhook::class, Manager::parseData('{"type":"'.Manager::TYPE_REQUEST_FULLY_ANSWERED.'","date":"2017-02-01T09:00:00+00:00","data":{}}'));
        $this->assertInstanceOf(RequestManualRevivedWebhook::class, Manager::parseData('{"type":"'.Manager::TYPE_REQUEST_MANUAL_REVIVED.'","date":"2017-02-01T09:00:00+00:00","data":{}}'));
        $this->assertInstanceOf(RequestOpenedWebhook::class, Manager::parseData('{"type":"'.Manager::TYPE_REQUEST_OPENED.'","date":"2017-02-01T09:00:00+00:00","data":{}}'));
        $this->assertInstanceOf(RequestSentWebhook::class, Manager::parseData('{"type":"'.Manager::TYPE_REQUEST_SENT.'","date":"2017-02-01T09:00:00+00:00","data":{}}'));

        // Tests fields are completed
        $data    = json_encode([
            'type'            => Manager::TYPE_REQUEST_SENT,
            'date'            => '2017-02-01T09:00:00+00:00',
            'data' => [
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
            ],
        ]);
        $webhook = Manager::parseData($data);
        $this->assertNotNull($webhook->getRequest());
        $this->assertEquals('ca52d6ff-259f-4b02-b11e-11d72af4d111', $webhook->getRequest()->getId());
    }
}
