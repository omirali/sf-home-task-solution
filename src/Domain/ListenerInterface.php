<?php

namespace App\Domain;

interface ListenerInterface
{
    /**
     * Handler a Domain Event
     *
     * @return void
     */
    public function handle(EventInterface $event);
}