<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Webhook\RequestFullyAnsweredWebhook;

class RequestFullyAnsweredWebhookFactory extends AbstractModelFactory
{
    /**
     * {@inheritdoc}
     *
     * @return RequestFullyAnsweredWebhook
     */
    public static function parseData(\stdClass $data)
    {
        $webhook = parent::parseDateFromData($data, new RequestFullyAnsweredWebhook());
        $data = $data->data;

        if (property_exists($data, 'request') && property_exists($data->request, 'data')) {
            $webhook->setRequest(RequestFactory::parseData($data->request->data));
        }

        return $webhook;
    }
}
