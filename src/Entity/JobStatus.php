<?php

namespace App\Entity;

use App\Repository\JobStatusRepository;
use App\Type\YesNo;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JobStatusRepository::class)]
class JobStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'jobStatuses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $job_status_short = null;

    #[ORM\Column(length: 255)]
    private ?string $job_status_long = null;

    #[ORM\Column]
    private ?int $job_order = null;

    #[ORM\Column(length: 7)]
    private ?string $job_color = null;

    #[ORM\Column(enumType: YesNo::class)]
    private ?YesNo $delete_flag = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompanyId(): ?Company
    {
        return $this->company_id;
    }

    public function setCompanyId(?Company $company_id): static
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getJobStatusShort(): ?string
    {
        return $this->job_status_short;
    }

    public function setJobStatusShort(string $job_status_short): static
    {
        $this->job_status_short = $job_status_short;

        return $this;
    }

    public function getJobStatusLong(): ?string
    {
        return $this->job_status_long;
    }

    public function setJobStatusLong(string $job_status_long): static
    {
        $this->job_status_long = $job_status_long;

        return $this;
    }

    public function getJobOrder(): ?int
    {
        return $this->job_order;
    }

    public function setJobOrder(int $job_order): static
    {
        $this->job_order = $job_order;

        return $this;
    }

    public function getJobColor(): ?string
    {
        return $this->job_color;
    }

    public function setJobColor(string $job_color): static
    {
        $this->job_color = $job_color;

        return $this;
    }

    public function getDeleteFlag(): ?YesNo
    {
        return $this->delete_flag;
    }

    public function setDeleteFlag(YesNo $delete_flag): static
    {
        $this->delete_flag = $delete_flag;

        return $this;
    }
}
