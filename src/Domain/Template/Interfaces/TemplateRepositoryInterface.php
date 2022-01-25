<?php

namespace App\Domain\Template\Interfaces;

interface TemplateRepositoryInterface
{
    public function findTemplateBySlug(string $slug);
}