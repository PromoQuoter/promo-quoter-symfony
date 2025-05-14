<?php

namespace App\Entity;

use App\Repository\NewsletterRepository;
use App\Type\YesNoShort;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NewsletterRepository::class)]
class Newsletter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $delete_flag = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $is_active = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $entry_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?DateTimeImmutable $modified_date = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDeleteFlag(): ?YesNoShort
    {
        return $this->delete_flag;
    }

    public function setDeleteFlag(YesNoShort $delete_flag): static
    {
        $this->delete_flag = $delete_flag;

        return $this;
    }

    public function getIsActive(): ?YesNoShort
    {
        return $this->is_active;
    }

    public function setIsActive(YesNoShort $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getEntryDate(): ?\DateTime
    {
        return $this->entry_date;
    }

    public function setEntryDate(\DateTime $entry_date): static
    {
        $this->entry_date = $entry_date;

        return $this;
    }

    public function getModifiedDate(): ?\DateTime
    {
        return $this->modified_date;
    }

    public function setModifiedDate(\DateTime $modified_date): static
    {
        $this->modified_date = $modified_date;

        return $this;
    }
}
