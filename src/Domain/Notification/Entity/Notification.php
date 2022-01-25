<?php

namespace App\Domain\Notification\Entity;

class Notification
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $recipient;
    private $channel;
    private $body;
    /**
     * @var false
     */
    private $dispatched;

    public function __construct(string $id, string $recipient, $channel, $body, $dispatched = false)
    {
        $this->id = $id;
        $this->recipient = $recipient;
        $this->channel = $channel;
        $this->body = $body;
        $this->dispatched = $dispatched;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }

    /**
     * @return mixed
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return false
     */
    public function getDispatched()
    {
        return $this->dispatched;
    }
}