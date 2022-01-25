<?php

namespace App\Domain\Verification\Events;

use App\Domain\EventInterface;

class VerificationConfirmationFailedEvent implements EventInterface
{

    public function name()
    {
        return 'VerificationConfirmationFailed';
    }
}