<?php

namespace App\Entity;

use App\Repository\QuotesEmailTrackerRepository;
use App\Type\YesNo;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotesEmailTrackerRepository::class)]
class QuotesEmailTracker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'quotes_id', type: Types::INTEGER)]
    #[ORM\OneToOne(inversedBy: 'quotesEmailTracker', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quotes $quotes_id = null;

    #[ORM\Column(length: 255)]
    private ?string $email_to = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email_from = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTime $email_send_date = null;

    #[ORM\Column(length: 255)]
    private ?string $track_code = null;

    #[ORM\Column(enumType: YesNo::class)]
    private ?YesNo $email_read_status = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $email_open_date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuotesId(): ?Quotes
    {
        return $this->quotes_id;
    }

    public function setQuotesId(Quotes $quotes_id): static
    {
        $this->quotes_id = $quotes_id;

        return $this;
    }

    public function getEmailTo(): ?string
    {
        return $this->email_to;
    }

    public function setEmailTo(string $email_to): static
    {
        $this->email_to = $email_to;

        return $this;
    }

    public function getEmailFrom(): ?string
    {
        return $this->email_from;
    }

    public function setEmailFrom(?string $email_from): static
    {
        $this->email_from = $email_from;

        return $this;
    }

    public function getEmailSendDate(): ?DateTime
    {
        return $this->email_send_date;
    }

    public function setEmailSendDate(DateTime $email_send_date): static
    {
        $this->email_send_date = $email_send_date;

        return $this;
    }

    public function getTrackCode(): ?string
    {
        return $this->track_code;
    }

    public function setTrackCode(string $track_code): static
    {
        $this->track_code = $track_code;

        return $this;
    }

    public function getEmailReadStatus(): ?YesNo
    {
        return $this->email_read_status;
    }

    public function setEmailReadStatus(YesNo $email_read_status): static
    {
        $this->email_read_status = $email_read_status;

        return $this;
    }

    public function getEmailOpenDate(): ?DateTime
    {
        return $this->email_open_date;
    }

    public function setEmailOpenDate(?DateTime $email_open_date): static
    {
        $this->email_open_date = $email_open_date;

        return $this;
    }
}
