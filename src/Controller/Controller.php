<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

abstract class Controller
{
    protected function requestPayload()
    {
        return json_decode(Request::createFromGlobals()->getContent(), true);
    }
}