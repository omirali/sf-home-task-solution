<?php

namespace App\Domain\Verification\Entity;

use App\Domain\Dispatcher;
use App\Domain\Verification\Events\VerificationConfirmedEvent;
use App\Domain\Verification\Events\VerificationCreatedEvent;
use App\Domain\Verification\ObjectValue\Subject;
use App\Domain\Verification\ObjectValue\UserInfo;

class Verification
{
    private $id;

    /**
     * @var Subject
     */
    private $subject;

    /**
     * @var false
     */
    private $confirmed;

    /**
     * @var \DateTimeImmutable|null
     */
    private $created_at;

    private $code;

    /**
     * @var UserInfo
     */
    private $user_info;

    /**
     * @var array
     */
    private $events;

    public function __construct(
        $id,
        Subject $subject,
        $confirmed,
        $code,
        UserInfo $user_info,
        \DateTimeImmutable $created_at = null
    ) {
        $this->id = $id;
        $this->subject = $subject;
        $this->confirmed = $confirmed;
        $this->code = $code;
        $this->user_info = $user_info;
        $this->created_at = $created_at;
    }

    public static function create($id, Subject $subject, $confirmed, $code, $user_info)
    {
        $verification = new Verification($id, $subject, $confirmed, $code, $user_info);
        $verification->addEvent(new VerificationCreatedEvent($verification));
        return $verification;
    }

    public function confirm()
    {
        $this->confirmed = true;
        $this->addEvent(new VerificationConfirmedEvent($this));
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Subject
     */
    public function getSubject(): Subject
    {
        return $this->subject;
    }

    /**
     * @return false
     */
    public function getConfirmed(): bool
    {
        return $this->confirmed;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return UserInfo
     */
    public function getUserInfo(): UserInfo
    {
        return $this->user_info;
    }

    public function addEvent($event)
    {
        $this->events[] = $event;
    }

    public function releaseEvents()
    {
        $events = $this->events;
        $this->events = [];
        return $events;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }
}