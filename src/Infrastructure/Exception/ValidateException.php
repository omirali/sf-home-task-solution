<?php

namespace App\Infrastructure\Exception;

class ValidateException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = 422;
        if (empty($message)) {
            $this->message = 'Validation failed.';
        }
    }
}