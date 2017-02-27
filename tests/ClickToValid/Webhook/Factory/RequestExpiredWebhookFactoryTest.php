<?php

namespace ClickToValid\Tests\Webhook\Factory;

use ClickToValid\Model\Request;
use ClickToValid\Webhook\Factory\RequestExpiredWebhookFactory;
use ClickToValid\Webhook\RequestExpiredWebhook;

class RequestExpiredWebhookFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        $data    = json_decode(json_encode([
            'date' => '2017-02-01T09:00:00+00:00',
            'data' => [
                'id' => '4ab717c1-3e8b-4ec6-b72b-93ccffb280dc',
            ],
        ]));
        $webhook = RequestExpiredWebhookFactory::parseData($data);

        // Tests we get the right Webhook
        $this->assertInstanceOf(RequestExpiredWebhook::class, $webhook);

        // Tests we get the right request
        $this->assertNotNull(Request::class, $webhook->getRequest());
        $this->assertEquals('4ab717c1-3e8b-4ec6-b72b-93ccffb280dc', $webhook->getRequest()->getId());
    }
}
