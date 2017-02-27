<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Model\Factory\RecipientFactory;
use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Webhook\RecipientAnsweredWebhook;

class RecipientAnsweredWebhookFactory extends AbstractModelFactory
{
    /**
     * {@inheritdoc}
     *
     * @return RecipientAnsweredWebhook
     */
    public static function parseData(\stdClass $data)
    {
        $webhook = parent::parseDateFromData($data, new RecipientAnsweredWebhook());
        $data    = $data->data;

        if (property_exists($data, 'id')) {
            $webhook->setRecipient(RecipientFactory::parseData($data));

            if (property_exists($data, 'request') && property_exists($data->request, 'data')) {
                $webhook->setRequest(RequestFactory::parseData($data->request->data));
            }
        }

        return $webhook;
    }
}
