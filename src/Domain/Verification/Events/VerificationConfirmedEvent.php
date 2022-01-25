<?php

namespace App\Domain\Verification\Events;

use App\Domain\EventInterface;

class VerificationConfirmedEvent implements EventInterface
{

    public function name()
    {
        return 'VerificationConfirmed';
    }
}