<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Model\Factory\RequestFactory;
use ClickToValid\Webhook\RequestExpiredWebhook;

class RequestExpiredWebhookFactory extends AbstractModelFactory
{
    /**
     * {@inheritdoc}
     *
     * @return RequestExpiredWebhook
     */
    public static function parseData(\stdClass $data)
    {
        $webhook = parent::parseDateFromData($data, new RequestExpiredWebhook());
        $data    = $data->data;

        if (property_exists($data, 'id')) {
            $webhook->setRequest(RequestFactory::parseData($data));
        }

        return $webhook;
    }
}
