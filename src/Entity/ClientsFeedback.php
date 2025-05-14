<?php

namespace App\Entity;

use App\Repository\ClientsFeedbackRepository;
use App\Type\YesNoShort;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientsFeedbackRepository::class)]
class ClientsFeedback
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $place = null;

    #[ORM\Column]
    private ?int $star = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $entry_date = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $modified_date = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $delete_flag = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $is_active = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): static
    {
        $this->place = $place;

        return $this;
    }

    public function getStar(): ?int
    {
        return $this->star;
    }

    public function setStar(int $star): static
    {
        $this->star = $star;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEntryDate(): ?DateTimeImmutable
    {
        return $this->entry_date;
    }

    public function setEntryDate(DateTimeImmutable $entry_date): static
    {
        $this->entry_date = $entry_date;

        return $this;
    }

    public function getModifiedDate(): ?DateTimeImmutable
    {
        return $this->modified_date;
    }

    public function setModifiedDate(DateTimeImmutable $modified_date): static
    {
        $this->modified_date = $modified_date;

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
}
