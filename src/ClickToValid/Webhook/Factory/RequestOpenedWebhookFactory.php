<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Model\Factory\RecipientFactory;
use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Webhook\RequestOpenedWebhook;

class RequestOpenedWebhookFactory extends AbstractModelFactory
{
    /**
     * {@inheritdoc}
     *
     * @return RequestOpenedWebhook
     */
    public static function parseData(\stdClass $data)
    {
        $webhook = parent::parseDateFromData($data, new RequestOpenedWebhook());
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
