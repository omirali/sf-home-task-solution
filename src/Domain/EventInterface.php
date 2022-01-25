<?php

namespace App\Domain;

interface EventInterface
{
    /**
     * Return the name of the Domain Event
     *
     * @return string
     */
    public function name();
}