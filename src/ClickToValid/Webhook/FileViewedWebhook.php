<?php

namespace ClickToValid\Webhook;

use ClickToValid\Model\File;
use ClickToValid\Model\Recipient;

class FileViewedWebhook extends AbstractRequestWebhook
{
    /**
     * @var File
     */
    private $file;

    /**
     * @var Recipient
     */
    private $recipient;

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     *
     * @return FileViewedWebhook
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

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
     * @return FileViewedWebhook
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;

        return $this;
    }
}
