<?php

namespace App\Domain\Verification\Listeners;

use App\Domain\EventInterface;
use App\Domain\ListenerInterface;

class VerificationConfirmationFailedListener implements ListenerInterface
{

    public function handle(EventInterface $event)
    {
        // TODO: Implement handle() method.
    }
}