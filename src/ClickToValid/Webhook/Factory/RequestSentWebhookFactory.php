<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Webhook\RequestSentWebhook;

class RequestSentWebhookFactory extends AbstractModelFactory
{
    /**
     * {@inheritdoc}
     *
     * @return RequestSentWebhook
     */
    public static function parseData(\stdClass $data)
    {
        $webhook = parent::parseDateFromData($data, new RequestSentWebhook());
        $data = $data->data;

        if (property_exists($data, 'request') && property_exists($data->request, 'data')) {
            $webhook->setRequest(RequestFactory::parseData($data->request->data));
        }

        return $webhook;
    }
}
