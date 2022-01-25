<?php

namespace App\Domain\Verification\Events;

use App\Domain\EventInterface;
use App\Domain\Verification\Entity\Verification;

class VerificationCreatedEvent implements EventInterface
{

    /**
     * @var Verification
     */
    private $verification;

    /**
     * @param Verification $verification
     */
    public function __construct(Verification $verification)
    {
        $this->verification = $verification;
    }

    public function getVerification()
    {
        return $this->verification;
    }

    public function name()
    {
        return 'VerificationCreated';
    }
}