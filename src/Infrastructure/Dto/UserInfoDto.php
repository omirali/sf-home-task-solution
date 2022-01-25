<?php

namespace App\Infrastructure\Dto;

use Symfony\Component\HttpFoundation\Request;

class UserInfoDto
{
    private $ip;
    private $user_agent;

    /**
     * @param $data
     * @return UserInfoDto
     */
    public static function fromRequest(Request $request): UserInfoDto
    {
        $self = new self();
        $self->ip = $request->getClientIp();
        $self->user_agent = $request->headers->get('User-Agent');
        return $self;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->user_agent;
    }
}