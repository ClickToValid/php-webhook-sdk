<?php

namespace ClickToValid\Webhook;

abstract class AbstractWebhook
{
    /**
     * @var \DateTime
     */
    private $date;

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     *
     * @return AbstractWebhook
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }
}
