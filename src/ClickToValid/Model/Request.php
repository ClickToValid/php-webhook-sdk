<?php

namespace ClickToValid\Model;

class Request
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $topic;

    /**
     * @var string
     */
    private $name;

    /**
     * @var boolean
     */
    private $hasMessage;

    /**
     * @var string
     */
    private $state;

    /**
     * @var \DateTime
     */
    private $dateExpiration;

    /**
     * @var \DateTime
     */
    private $dateSent;

    /**
     * @var User
     */
    private $sender;

    /**
     * @var array
     */
    private $recipients;

    /**
     * @var array
     */
    private $files;

    public function __construct()
    {
        $this->recipients = [];
        $this->files      = [];
    }

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
     * @return Request
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     *
     * @return Request
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Request
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return bool
     */
    public function getHasMessage()
    {
        return $this->hasMessage;
    }

    /**
     * @param bool $hasMessage
     *
     * @return Request
     */
    public function setHasMessage($hasMessage)
    {
        $this->hasMessage = $hasMessage;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Request
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateExpiration()
    {
        return $this->dateExpiration;
    }

    /**
     * @param mixed $dateExpiration
     *
     * @return Request
     */
    public function setDateExpiration($dateExpiration)
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateSent()
    {
        return $this->dateSent;
    }

    /**
     * @param \DateTime $dateSent
     *
     * @return Request
     */
    public function setDateSent($dateSent)
    {
        $this->dateSent = $dateSent;

        return $this;
    }

    /**
     * @return User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param User $sender
     *
     * @return Request
     */
    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * @return array
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param array $recipients
     *
     * @return Request
     */
    public function setRecipients($recipients)
    {
        $this->recipients = $recipients;

        return $this;
    }

    /**
     * @param Recipient $recipient
     *
     * @return Request
     */
    public function addRecipient(Recipient $recipient)
    {
        $this->recipients[] = $recipient;

        return $this;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param array $files
     *
     * @return Request
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * @param File $file
     *
     * @return Request
     */
    public function addFile(File $file)
    {
        $this->files[] = $file;

        return $this;
    }
}
