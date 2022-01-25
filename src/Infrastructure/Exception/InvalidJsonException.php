<?php

namespace App\Infrastructure\Exception;

use Throwable;

class InvalidJsonException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = 400;
        if (empty($message)) {
            $this->message = 'Malformed JSON passed.';
        }
    }
}