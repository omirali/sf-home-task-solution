<?php

namespace App\Infrastructure\Dto;

class TemplateDto
{
    /**
     * @var string
     */
    public $slug;

    public $variables;

    /**
     * @param $data
     * @return TemplateVariablesDto
     */
    public static function fromArray($data): TemplateDto
    {
        $self = new self();
        $self->slug = $data['slug'] ?? null;
        $self->variables = $data['variables'] ?? [];
        return $self;
    }
}