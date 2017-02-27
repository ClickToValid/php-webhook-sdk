<?php

namespace ClickToValid\Model\Factory;

use ClickToValid\Exception\RequestExpirationDateNotValidException;
use ClickToValid\Exception\RequestSentDateNotValidException;
use ClickToValid\Model\Request;

class RequestFactory
{
    /**
     * @param \stdClass $data
     *
     * @return Request
     * @throws RequestExpirationDateNotValidException
     * @throws RequestSentDateNotValidException
     */
    public static function parseData(\stdClass $data)
    {
        $request = new Request();

        if (property_exists($data, 'id')) {
            $request->setId($data->id);
        }

        if (property_exists($data, 'topic')) {
            $request->setTopic($data->topic);
        }

        if (property_exists($data, 'name')) {
            $request->setName($data->name);
        }

        if (property_exists($data, 'has_message')) {
            $request->setHasMessage($data->has_message);
        }

        if (property_exists($data, 'state')) {
            $request->setState($data->state);
        }

        if (property_exists($data, 'date_expiration') &&
            null !== $data->date_expiration
        ) {
            if (false === ($date = \DateTime::createFromFormat(\DateTime::ISO8601, $data->date_expiration))) {
                throw new RequestExpirationDateNotValidException('The expiration_date of the parsed request has not a valid format.');
            }

            $request->setDateExpiration($date);
        }

        if (property_exists($data, 'date_sent') &&
            null !== $data->date_sent
        ) {
            if (false === ($date = \DateTime::createFromFormat(\DateTime::ISO8601, $data->date_sent))) {
                throw new RequestSentDateNotValidException('The date_sent of the parsed request has not a valid format.');
            }

            $request->setDateSent($date);
        }

        if (property_exists($data, 'sender') && property_exists($data->sender, 'data')) {
            $request->setSender(UserFactory::parseData($data->sender->data));
        }

        if (property_exists($data, 'recipients') && property_exists($data->recipients, 'data')) {
            foreach ($data->recipients->data as $recipientData) {
                $request->addRecipient(RecipientFactory::parseData($recipientData));
            }
        }

        if (property_exists($data, 'files') && property_exists($data->files, 'data')) {
            foreach ($data->files->data as $filesData) {
                $request->addFile(FileFactory::parseData($filesData));
            }
        }

        return $request;
    }
}
