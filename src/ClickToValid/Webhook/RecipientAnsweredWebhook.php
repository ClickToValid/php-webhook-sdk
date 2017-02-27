<?php

namespace ClickToValid\Webhook;

use ClickToValid\Model\Recipient;

class RecipientAnsweredWebhook extends AbstractRequestWebhook
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
     * @return RecipientAnsweredWebhook
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }
}
