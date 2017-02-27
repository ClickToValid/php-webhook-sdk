<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Exception\WebhookDateMissingException;
use ClickToValid\Exception\WebhookDateNotValidException;
use ClickToValid\Webhook\AbstractWebhook;

abstract class AbstractModelFactory implements WebhookFactoryInterface
{
    /**
     * @param \stdClass       $data
     * @param AbstractWebhook $webhook
     *
     * @return AbstractWebhook
     * @throws WebhookDateMissingException
     * @throws WebhookDateNotValidException
     */
    public static function parseDateFromData(\stdClass $data, AbstractWebhook $webhook)
    {
        if (false === property_exists($data, 'date')) {
            throw new WebhookDateMissingException('The event date is missing in parsed data.');
        }

        if (false === ($date = \DateTime::createFromFormat(\DateTime::ISO8601, $data->date))) {
            throw new WebhookDateNotValidException('The event date has not a valid ISO 8601 format.');
        }

        $webhook->setDate($date);

        return $webhook;
    }
}
