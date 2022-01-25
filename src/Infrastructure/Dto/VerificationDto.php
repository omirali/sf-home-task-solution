<?php

namespace App\Infrastructure\Dto;

use App\Infrastructure\Exception\InvalidJsonException;
use App\Infrastructure\Exception\ValidateException;
use App\Template\Domain\Dto\TemplateDto;
use App\Template\Domain\Dto\TemplateVariablesDto;

class VerificationDto
{
    /**
     * @var object
     */
    private $subject;

    /**
     * @param $data
     * @return VerificationDto
     */
    public static function fromArray($data): VerificationDto
    {
        if (!isset($data['subject']) ||
            !isset($data['subject']['type']) ||
            !isset($data['subject']['identity'])) {
            throw new InvalidJsonException();
        }

        if (!in_array($data['subject']['type'], ['email_confirmation', 'mobile_confirmation'])) {
            throw new ValidateException('Validation failed: invalid subject supplied.');
        }

        $self = new self();
        $self->subject = (object)[
            'type' => $data['subject']['type'],
            'identity' => $data['subject']['identity']
        ];
        return $self;
    }

    public function getSubject()
    {
        return $this->subject;
    }
}