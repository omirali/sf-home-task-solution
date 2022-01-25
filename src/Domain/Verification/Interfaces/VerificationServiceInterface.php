<?php

namespace App\Domain\Verification\Interfaces;

use App\Domain\Verification\ObjectValue\Subject;
use App\Domain\Verification\ObjectValue\UserInfo;

interface VerificationServiceInterface
{
    public function create($data);

    public function confirm($id, $data);

    public function canBeCreate($type, $identity, UserInfo $userInfo);
}