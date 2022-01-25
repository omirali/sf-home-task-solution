<?php

namespace App\Infrastructure\Exception;

use Throwable;

class DublicateExeption extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = 409;
        if (empty($message)) {
            $this->message = 'Dublicate exeption.';
        }
    }
}