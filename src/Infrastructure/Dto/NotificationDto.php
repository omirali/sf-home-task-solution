<?php

namespace App\Infrastructure\Dto;

class NotificationDto
{
    /**
     * @var mixed|null
     */
    private $identity;
    /**
     * @var array|mixed
     */
    private $type;
    /**
     * @var array|mixed
     */
    private $code;

    /**
     * @param $data
     * @return NotificationDto
     */
    public static function fromArray($data): NotificationDto
    {
        $self = new self();
        $self->identity = $data['identity'] ?? null;
        $self->type = $data['type'] ?? [];
        $self->code = $data['code'] ?? [];
        return $self;
    }

    /**
     * @return mixed|null
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return array|mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array|mixed
     */
    public function getCode()
    {
        return $this->code;
    }
}