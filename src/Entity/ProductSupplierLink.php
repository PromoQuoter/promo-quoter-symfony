<?php

namespace App\Entity;

use App\Repository\ProductSupplierLinkRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductSupplierLinkRepository::class)]
class ProductSupplierLink
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

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[ORM\Column(name: 'supplier_id', type: Types::INTEGER)]
    private ?Supplier $supplier_id = null;

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

    public function getSupplierId(): ?Supplier
    {
        return $this->supplier_id;
    }

    public function setSupplierId(?Supplier $supplier_id): static
    {
        $this->supplier_id = $supplier_id;

        return $this;
    }
}
