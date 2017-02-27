<?php

namespace ClickToValid\Webhook\Factory;

use ClickToValid\Webhook\AbstractWebhook;

interface WebhookFactoryInterface
{
    /**
     * @param \stdClass $data
     *
     * @return AbstractWebhook
     */
    public static function parseData(\stdClass $data);
}
