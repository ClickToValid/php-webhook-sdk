<?php

namespace ClickToValid\Model;

class Recipient
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $dateAnswer;

    /**
     * @var string
     */
    private $answer;

    /**
     * @var User
     */
    private $receiver;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return Recipient
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateAnswer()
    {
        return $this->dateAnswer;
    }

    /**
     * @param \DateTime $dateAnswer
     *
     * @return Recipient
     */
    public function setDateAnswer($dateAnswer)
    {
        $this->dateAnswer = $dateAnswer;

        return $this;
    }

    /**
     * @return string
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param string $answer
     *
     * @return Recipient
     */
    public function setAnswer($answer)
    {
        $this->answer = $answer;

        return $this;
    }

    /**
     * @return User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param User $receiver
     *
     * @return Recipient
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }
}
