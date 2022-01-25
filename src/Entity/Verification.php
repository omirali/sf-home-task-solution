<?php

namespace App\Entity;

use App\Infrastructure\Repository\VerificationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VerificationRepository::class)
 */
class Verification
{
    /**
     * @ORM\Column(name="id", type="guid")
     * @ORM\Id()
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identity;

    /**
     * @ORM\Column(type="float")
     */
    private $confirmed = false;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $user_info;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $code;

    public function getId(): ?string
    {
        return $this->id;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    public function setIdentity(string $identity): self
    {
        $this->identity = $identity;

        return $this;
    }

    public function getConfirmed(): ?float
    {
        return $this->confirmed;
    }

    public function setConfirmed(float $confirmed): self
    {
        $this->confirmed = $confirmed;

        return $this;
    }

    public function getUserInfo(): ?object
    {
        return json_decode($this->user_info);
    }

    public function setUserInfo(?string $user_info): self
    {
        $this->user_info = $user_info;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }
}
