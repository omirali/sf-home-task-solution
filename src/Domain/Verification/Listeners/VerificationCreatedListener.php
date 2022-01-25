<?php

namespace App\Domain\Verification\Listeners;


use App\Domain\EventInterface;
use App\Domain\ListenerInterface;
use App\Domain\Verification\Entity\Verification;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class VerificationCreatedListener implements ListenerInterface
{
    /**
     * @var AMQPStreamConnection
     */
    private $connection;

    /**
     * @var \PhpAmqpLib\Channel\AbstractChannel|\PhpAmqpLib\Channel\AMQPChannel
     */
    private $channel;

    public function __construct()
    {
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
    }

    public function handle(EventInterface $event)
    {
        /**
         * @var $verification Verification
         */
        $verification = $event->getVerification();

        $this->channel->queue_declare($event->name(), false, false, false, false);

        $msg = new AMQPMessage(json_encode([
            'identity' => $verification->getSubject()->getIdentity(),
            'type' => $verification->getSubject()->getType(),
            'code' => $verification->getCode()
        ]));
        $this->channel->basic_publish($msg, '', $event->name());
        $this->channel->close();
        $this->connection->close();
        return true;
    }

    public function __destruct()
    {
        $this->channel->close();
        $this->connection->close();
    }
}