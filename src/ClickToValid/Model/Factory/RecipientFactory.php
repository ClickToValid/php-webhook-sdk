<?php

namespace ClickToValid\Model\Factory;

use ClickToValid\Exception\RecipientAnswerDateNotValidException;
use ClickToValid\Model\Recipient;

class RecipientFactory
{
    /**
     * @param \stdClass $data
     *
     * @return Recipient
     * @throws RecipientAnswerDateNotValidException
     */
    public static function parseData(\stdClass $data)
    {
        $recipient = new Recipient();

        if (property_exists($data, 'id')) {
            $recipient->setId($data->id);
        }

        if (property_exists($data, 'date_answer') &&
            null !== $data->date_answer
        ) {
            if (false === ($date = \DateTime::createFromFormat(\DateTime::ISO8601, $data->date_answer))) {
                throw new RecipientAnswerDateNotValidException('The date_answer of the parsed recipient has not a valid format.');
            }

            $recipient->setDateAnswer($date);
        }

        if (property_exists($data, 'answer')) {
            $recipient->setAnswer($data->answer);
        }

        if (property_exists($data, 'receiver') && property_exists($data->receiver, 'data')) {
            $recipient->setReceiver(UserFactory::parseData($data->receiver->data));
        }

        return $recipient;
    }
}
