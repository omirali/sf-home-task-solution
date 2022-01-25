<?php

namespace App\Infrastructure\Exception;

use Throwable;

class NoPermissionException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->code = 403;
        if (empty($message)) {
            $this->message = 'No permission to confirm verification.';
        }
    }
}