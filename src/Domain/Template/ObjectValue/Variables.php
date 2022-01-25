<?php

namespace App\Domain\Template\ObjectValue;

class Variables
{
    /**
     * @var string
     */
    private $code;

    public function __construct($code)
    {
        $this->code = $code;
    }

    public function toArray()
    {
        return [
            'code' => $this->code
        ];
    }
}