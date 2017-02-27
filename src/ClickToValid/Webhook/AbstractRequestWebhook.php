<?php

namespace ClickToValid\Webhook;

use ClickToValid\Model\Request;

abstract class AbstractRequestWebhook extends AbstractWebhook
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param Request $request
     *
     * @return AbstractRequestWebhook
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }
}
