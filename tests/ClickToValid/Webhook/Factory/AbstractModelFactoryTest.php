<?php

namespace ClickToValid\Tests\Webhook\Factory;

use ClickToValid\Exception\AbstractException;
use ClickToValid\Exception\WebhookDateMissingException;
use ClickToValid\Exception\WebhookDateNotValidException;
use ClickToValid\Webhook\AbstractWebhook;
use ClickToValid\Webhook\Factory\AbstractModelFactory;
use ClickToValid\Webhook\FileViewedWebhook;

class AbstractModelFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseDateFromData()
    {
        $webhook = new FileViewedWebhook();
        $data    = new \stdClass();

        // Tests not well formated date thrown WebhookDateMissingException
        $exception = false;
        try {
            AbstractModelFactory::parseDateFromData($data, $webhook);
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(WebhookDateMissingException::class, $e);
        }
        $this->assertTrue($exception);

        // Tests not well formated date thrown WebhookDateNotValidException
        $exception  = false;
        $data->date = 'not-well-formatted';
        try {
            AbstractModelFactory::parseDateFromData($data, $webhook);
        } catch (AbstractException $e) {
            $exception = true;
            $this->assertInstanceOf(WebhookDateNotValidException::class, $e);
        }
        $this->assertTrue($exception);

        // Tests we get Webhook and valid datetime when date well formatted
        $data->date = '2017-02-01T09:00:00+00:00';
        $webhook    = AbstractModelFactory::parseDateFromData($data, $webhook);
        $this->assertInstanceOf(AbstractWebhook::class, $webhook);
        $this->assertInstanceOf(\DateTime::class, $webhook->getDate());
        $this->assertEquals(1485939600, $webhook->getDate()->getTimestamp());
    }
}
