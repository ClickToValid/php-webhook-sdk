<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Model\Factory\FileFactory;
use ClickToValid\Model\Factory\RecipientFactory;
use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Webhook\FileViewedWebhook;

class FileViewedWebhookFactory extends AbstractModelFactory
{
    /**
     * {@inheritdoc}
     *
     * @return FileViewedWebhook
     */
    public static function parseData(\stdClass $data)
    {
        $webhook = parent::parseDateFromData($data, new FileViewedWebhook());
        $data = $data->data;

        if (property_exists($data, 'file') && property_exists($data->file, 'data')) {
            $webhook->setFile(FileFactory::parseData($data->file->data));
        }

        if (property_exists($data, 'recipient') && property_exists($data->recipient, 'data')) {
            $webhook->setRecipient(RecipientFactory::parseData($data->recipient->data));
        }

        if (property_exists($data, 'request') && property_exists($data->request, 'data')) {
            $webhook->setRequest(RequestFactory::parseData($data->request->data));
        }

        return $webhook;
    }
}
