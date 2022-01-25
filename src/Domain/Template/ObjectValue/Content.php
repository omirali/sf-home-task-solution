<?php

namespace App\Domain\Template\ObjectValue;

class Content
{
    private $content;

    /**
     * @param $content
     * @param $extension
     */
    public function __construct($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }
}