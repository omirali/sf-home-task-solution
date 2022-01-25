<?php

namespace App\Domain\Verification\Interfaces;

interface VerificationRepositoryInterface
{
    public function createVerification($data);
    public function findVerificationById($id);
    public function getLastAvailableVerification($type, $identity, $userInfo, $ttl);
}