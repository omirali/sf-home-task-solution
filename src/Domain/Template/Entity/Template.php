<?php

namespace App\Domain\Template\Entity;

use App\Domain\Template\ObjectValue\Content;
use App\Domain\Template\ObjectValue\Variables;

class Template
{
    /**
     * @var string
     */
    private $slug;

    /**
     * @var Content
     */
    private $content;

    /**
     * @var Variables
     */
    private $variables;

    public function __construct($slug, Content $content, Variables $variables)
    {
        $this->slug = $slug;
        $this->content = $content;
        $this->variables = $variables;
    }

    /**
     * @return Content
     */
    public function getContent(): Content
    {
        return $this->content;
    }

    /**
     * @return Variables
     */
    public function getVariables(): Variables
    {
        return $this->variables;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }
}