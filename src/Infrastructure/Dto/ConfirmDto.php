<?php

namespace App\Infrastructure\Dto;

use App\Infrastructure\Exception\InvalidJsonException;
use App\Infrastructure\Exception\ValidateException;

class ConfirmDto
{
    /**
     * @var string
     */
    private $code;

    /**
     * @param $data
     * @return ConfirmDto
     */
    public static function fromArray($data): ConfirmDto
    {
        if (empty($data) || !isset($data['code'])) {
            throw new InvalidJsonException();
        }

        $self = new self();
        $self->code = $data['code'];
        return $self;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }
}