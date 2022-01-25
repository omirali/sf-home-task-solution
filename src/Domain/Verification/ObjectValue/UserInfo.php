<?php

namespace App\Domain\Verification\ObjectValue;

class UserInfo
{
    private $ip;

    private $userAgent;

    public function __construct($ip, $userAgent)
    {
        $this->ip = $ip;
        $this->userAgent = $userAgent;
    }

    /**
     * @return mixed
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    public function __toString()
    {
        return json_encode([
            'ip' => $this->getIp(),
            'user_agent' => $this->getUserAgent()
        ]);
    }

}