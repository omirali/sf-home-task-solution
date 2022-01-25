<?php

namespace App\Domain\Notification\Interfaces;

interface NotificationServiceInterface
{
    public function sendNotification($data);
}