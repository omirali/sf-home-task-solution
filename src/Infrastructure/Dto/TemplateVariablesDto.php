<?php

namespace App\Infrastructure\Dto;


use InvalidArgumentException;

class TemplateVariablesDto
{
    /**
     * @var string
     */
    public $code;

    /**
     * @param $data
     * @return TemplateVariablesDto
     */
    public static function fromArray($data): TemplateVariablesDto
    {
        if (!isset($data['code'])) {
            throw new InvalidArgumentException('Validation failed: invalid / missing variables supplied.',422);
        }
        $self = new self();
        $self->code = $data['code'];
        return $self;
    }
}