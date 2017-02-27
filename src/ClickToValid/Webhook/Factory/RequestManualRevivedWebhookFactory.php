<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Webhook\RequestManualRevivedWebhook;

class RequestManualRevivedWebhookFactory extends AbstractModelFactory
{
    /**
     * {@inheritdoc}
     *
     * @return RequestManualRevivedWebhook
     */
    public static function parseData(\stdClass $data)
    {
        $webhook = parent::parseDateFromData($data, new RequestManualRevivedWebhook());
        $data = $data->data;

        if (property_exists($data, 'request') && property_exists($data->request, 'data')) {
            $webhook->setRequest(RequestFactory::parseData($data->request->data));
        }

        return $webhook;
    }
}
