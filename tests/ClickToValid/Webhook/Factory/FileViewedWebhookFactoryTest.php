<?php

namespace ClickToValid\Tests\Webhook\Factory;

use ClickToValid\Model\File;
use ClickToValid\Model\Recipient;
use ClickToValid\Model\Request;
use ClickToValid\Webhook\Factory\FileViewedWebhookFactory;
use ClickToValid\Webhook\FileViewedWebhook;

class FileViewedWebhookFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testParseData()
    {
        $data    = json_decode(json_encode([
            'date' => '2017-02-01T09:00:00+00:00',
            'data' => [
                'file'      => [
                    'data' => [
                        'id' => 'c4ec2ca7-57a2-40a0-8beb-2e19fd7eafed',
                    ],
                ],
                'recipient' => [
                    'data' => [
                        'id' => '9ad10ec1-88ab-42f7-b414-df3c54918f19',
                    ],
                ],
                'request'   => [
                    'data' => [
                        'id' => '4ab717c1-3e8b-4ec6-b72b-93ccffb280dc',
                    ],
                ],
            ],
        ]));
        $webhook = FileViewedWebhookFactory::parseData($data);

        // Tests we get the right Webhook
        $this->assertInstanceOf(FileViewedWebhook::class, $webhook);

        // Tests we get the right file
        $this->assertNotNull(File::class, $webhook->getFile());
        $this->assertEquals('c4ec2ca7-57a2-40a0-8beb-2e19fd7eafed', $webhook->getFile()->getId());

        // Tests we get the right recipient
        $this->assertNotNull(Recipient::class, $webhook->getRecipient());
        $this->assertEquals('9ad10ec1-88ab-42f7-b414-df3c54918f19', $webhook->getRecipient()->getId());

        // Tests we get the right request
        $this->assertNotNull(Request::class, $webhook->getRequest());
        $this->assertEquals('4ab717c1-3e8b-4ec6-b72b-93ccffb280dc', $webhook->getRequest()->getId());
    }
}
