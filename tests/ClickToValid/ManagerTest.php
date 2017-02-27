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
    }
}
