<?php

namespace App\Entity;

use App\Repository\BookDemoRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookDemoRepository::class)]
class BookDemo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $cuid = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    #[ORM\Column(length: 255)]
    private ?string $organization = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column]
    private ?DateTime $date = null;

    #[ORM\Column(length: 255)]
    private ?string $playform = null;

    #[ORM\Column(length: 255)]
    private ?string $platform_username = null;

    #[ORM\Column(length: 255)]
    private ?string $notes = null;

    #[ORM\Column]
    private ?DateTime $created_at = null;

    #[ORM\Column]
    private ?DateTime $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCuid(): ?string
    {
        return $this->cuid;
    }

    public function setCuid(string $cuid): static
    {
        $this->cuid = $cuid;

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getOrganization(): ?string
    {
        return $this->organization;
    }

    public function setOrganization(string $organization): static
    {
        $this->organization = $organization;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPlayform(): ?string
    {
        return $this->playform;
    }

    public function setPlayform(string $playform): static
    {
        $this->playform = $playform;

        return $this;
    }

    public function getPlatformUsername(): ?string
    {
        return $this->platform_username;
    }

    public function setPlatformUsername(string $platform_username): static
    {
        $this->platform_username = $platform_username;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }
}
