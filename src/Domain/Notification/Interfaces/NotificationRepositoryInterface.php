<?php

namespace App\Domain\Notification\Interfaces;

interface NotificationRepositoryInterface
{
    public function create($data);
}