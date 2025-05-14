<?php

namespace App\Entity;

use App\Repository\SupplierXeroKeyRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SupplierXeroKeyRepository::class)]
class SupplierXeroKey
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'supplier_id', type: Types::INTEGER)]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Supplier $supplier_id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $xero_key = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSupplierId(): ?Supplier
    {
        return $this->supplier_id;
    }

    public function setSupplierId(Supplier $supplier_id): static
    {
        $this->supplier_id = $supplier_id;

        return $this;
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
