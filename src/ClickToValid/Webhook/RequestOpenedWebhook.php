<?php

namespace ClickToValid\Webhook;

use ClickToValid\Model\Recipient;

class RequestOpenedWebhook extends AbstractRequestWebhook
{
    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @param Recipient $recipient
     *
     * @return RequestOpenedWebhook
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }
}
