<?php

namespace App\Entity;

use App\Repository\FaqRepository;
use App\Type\YesNoShort;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FaqRepository::class)]
class Faq
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $question = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $answer = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $delete_flag = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $is_active = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $entry_date = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $modified_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): static
    {
        $this->answer = $answer;

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
}
