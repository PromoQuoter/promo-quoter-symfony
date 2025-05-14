<?php

namespace App\Entity;

use App\Repository\ContactUsRepository;
use App\Type\YesNoShort;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactUsRepository::class)]
class ContactUs
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $subject = null;

    #[ORM\Column(length: 255)]
    private ?string $msg = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMsg(): ?string
    {
        return $this->msg;
    }

    public function setMsg(string $msg): static
    {
        $this->msg = $msg;

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
