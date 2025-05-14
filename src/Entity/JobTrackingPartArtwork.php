<?php

namespace App\Entity;

use App\Repository\JobTrackingPartArtworkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: JobTrackingPartArtworkRepository::class)]
class JobTrackingPartArtwork
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'job_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne(inversedBy: 'artwork')]
    private ?JobTracking $job_id = null;

    #[ORM\Column(length: 255)]
    private ?string $job_part_id = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reject_reason = null;

    #[ORM\Column(length: 1)]
    private ?string $approved_rejected = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sender_email = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobId(): ?JobTracking
    {
        return $this->job_id;
    }

    public function setJobId(?JobTracking $job_id): static
    {
        $this->job_id = $job_id;

        return $this;
    }

    public function getJobPartId(): ?string
    {
        return $this->job_part_id;
    }

    public function setJobPartId(string $job_part_id): static
    {
        $this->job_part_id = $job_part_id;

        return $this;
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

    public function getRejectReason(): ?string
    {
        return $this->reject_reason;
    }

    public function setRejectReason(?string $reject_reason): static
    {
        $this->reject_reason = $reject_reason;

        return $this;
    }

    public function getApprovedRejected(): ?string
    {
        return $this->approved_rejected;
    }

    public function setApprovedRejected(string $approved_rejected): static
    {
        $this->approved_rejected = $approved_rejected;

        return $this;
    }

    public function getSenderEmail(): ?string
    {
        return $this->sender_email;
    }

    public function setSenderEmail(?string $sender_email): static
    {
        $this->sender_email = $sender_email;

        return $this;
    }
}
