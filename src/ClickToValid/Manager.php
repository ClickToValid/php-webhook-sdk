<?php

namespace ClickToValid;

use ClickToValid\Exception\AbstractException;
use ClickToValid\Exception\NotValidJsonException;
use ClickToValid\Exception\WebhookNoDataFoundException;
use ClickToValid\Exception\WebhookTypeMissingException;
use ClickToValid\Exception\WebhookTypeNotManagedException;
use ClickToValid\Webhook\AbstractWebhook;
use ClickToValid\Webhook\Factory\FileViewedWebhookFactory;
use ClickToValid\Webhook\Factory\RecipientAnsweredWebhookFactory;
use ClickToValid\Webhook\Factory\RequestExpiredWebhookFactory;
use ClickToValid\Webhook\Factory\RequestFullyAnsweredWebhookFactory;
use ClickToValid\Webhook\Factory\RequestManualRevivedWebhookFactory;
use ClickToValid\Webhook\Factory\RequestOpenedWebhookFactory;
use ClickToValid\Webhook\Factory\RequestSentWebhookFactory;

class Manager
{
    const TYPE_REQUEST_OPENED         = 'request-opened';
    const TYPE_FILE_VIEWED            = 'file-viewed';
    const TYPE_RECIPIENT_ANSWERED     = 'recipient-answered';
    const TYPE_REQUEST_FULLY_ANSWERED = 'request-answered-fully';
    const TYPE_REQUEST_EXPIRED        = 'request-expired';
    const TYPE_REQUEST_MANUAL_REVIVED = 'request-manual-revived';
    const TYPE_REQUEST_SENT           = 'request-sent';

    /**
     * Parse received data
     *
     * @param string $data
     *
     * @return AbstractWebhook
     * @throws AbstractException
     */
    public static function parseData($data)
    {
        if (!($data = json_decode($data))) {
            throw new NotValidJsonException('The data you are trying to parse is not valid JSON.');
        }

        if (false === property_exists($data, 'type')) {
            throw new WebhookTypeMissingException('The webhook type is missing in parsed data : can\'t determine the event.');
        }

        if (false === property_exists($data, 'data')) {
            throw new WebhookNoDataFoundException('There is no data found to parse.');
        }

        switch ($data->type) {
            case self::TYPE_FILE_VIEWED:
                return FileViewedWebhookFactory::parseData($data);
                break;
            case self::TYPE_RECIPIENT_ANSWERED:
                return RecipientAnsweredWebhookFactory::parseData($data);
                break;
            case self::TYPE_REQUEST_EXPIRED:
                return RequestExpiredWebhookFactory::parseData($data);
                break;
            case self::TYPE_REQUEST_FULLY_ANSWERED:
                return RequestFullyAnsweredWebhookFactory::parseData($data);
                break;
            case self::TYPE_REQUEST_MANUAL_REVIVED:
                return RequestManualRevivedWebhookFactory::parseData($data);
                break;
            case self::TYPE_REQUEST_OPENED:
                return RequestOpenedWebhookFactory::parseData($data);
                break;
            case self::TYPE_REQUEST_SENT:
                return RequestSentWebhookFactory::parseData($data);
                break;
        }

        throw new WebhookTypeNotManagedException('The webhook type in parsed data is not managed by this library.');
    }
}
