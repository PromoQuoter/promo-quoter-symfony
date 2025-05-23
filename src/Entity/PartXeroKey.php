<?php

namespace App\Entity;

use App\Repository\PartXeroKeyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Index(name: 'part_id', columns: ['part_id'])]
#[ORM\Entity(repositoryClass: PartXeroKeyRepository::class)]
class PartXeroKey
{
    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    private ?Company $company_id = null;

    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\Column(name: 'part_id', type: Types::INTEGER)]
    private ?PartDatabase $part_id = null;

    #[ORM\Column(length: 255)]
    private ?string $xero_key = null;

    public function getCompanyId(): ?Company
    {
        return $this->company_id;
    }

    public function setCompanyId(?Company $company_id): static
    {
        $this->company_id = $company_id;

        return $this;
    }

    public function getPartId(): ?PartDatabase
    {
        return $this->part_id;
    }

    public function setPartId(?PartDatabase $part_id): static
    {
        $this->part_id = $part_id;

        return $this;
    }

    public function getXeroKey(): ?string
    {
        return $this->xero_key;
    }

    public function setXeroKey(string $xero_key): static
    {
        $this->xero_key = $xero_key;

        return $this;
    }
}
