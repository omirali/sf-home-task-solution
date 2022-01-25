<?php

namespace App\Domain\Verification\ObjectValue;

class Subject
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $identity;

    public function __construct(string $type, string $identity)
    {
        $this->type = $type;
        $this->identity = $identity;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->identity;
    }

}