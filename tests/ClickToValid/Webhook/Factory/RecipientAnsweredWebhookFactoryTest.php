<?php

namespace ClickToValid\Tests\Webhook\Factory;

use ClickToValid\Model\Recipient;
use ClickToValid\Model\Request;
use ClickToValid\Webhook\Factory\RecipientAnsweredWebhookFactory;
use ClickToValid\Webhook\RecipientAnsweredWebhook;

class RecipientAnsweredWebhookFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        $data    = json_decode(json_encode([
            'date' => '2017-02-01T09:00:00+00:00',
            'data' => [
                'recipient' => [
                    'data' => [
                        'id'      => '9ad10ec1-88ab-42f7-b414-df3c54918f19',
                        'request' => [
                            'data' => [
                                'id' => '4ab717c1-3e8b-4ec6-b72b-93ccffb280dc',
                            ],
                        ],
                    ],
                ],
            ],
        ]));
        $webhook = RecipientAnsweredWebhookFactory::parseData($data);

        // Tests we get the right Webhook
        $this->assertInstanceOf(RecipientAnsweredWebhook::class, $webhook);

        // Tests we get the right recipient
        $this->assertNotNull(Recipient::class, $webhook->getRecipient());
        $this->assertEquals('9ad10ec1-88ab-42f7-b414-df3c54918f19', $webhook->getRecipient()->getId());

        // Tests we get the right request
        $this->assertNotNull(Request::class, $webhook->getRequest());
        $this->assertEquals('4ab717c1-3e8b-4ec6-b72b-93ccffb280dc', $webhook->getRequest()->getId());
    }
}
