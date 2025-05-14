<?php

namespace App\Entity;

use App\Repository\PartDatabaseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Index(name: 'company_id', columns: ['company_id'])]
#[ORM\Index(name: 'search_brand_ft', columns: ['part_number', 'part_name', 'brand'], flags: ['fulltext'])]
#[ORM\Index(name: 'part_number_name_ft', columns: ['part_number', 'part_name'], flags: ['fulltext'])]
#[ORM\Index(name: 'part_number', columns: ['part_number'])]
#[ORM\Index(name: 'part_number_ft', columns: ['part_number'], flags: ['fulltext'])]
#[ORM\Index(name: 'part_name_ft', columns: ['part_name'], flags: ['fulltext'])]
#[ORM\Index(name: 'supplier_id', columns: ['supplier_id'])]
#[ORM\Entity(repositoryClass: PartDatabaseRepository::class)]
class PartDatabase
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $part_number = null;

    #[ORM\Column(length: 255)]
    private ?string $part_name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $component_type = null;

    #[ORM\Column]
    private ?int $setup = null;

    #[ORM\Column]
    private array $costs = [];

    #[ORM\Column]
    private ?int $cost_taxable = null;

    #[ORM\Column]
    private ?int $setup_taxable = null;

    #[ORM\Column(options: ['default' => 'JSON_ARRAY()'])]
    private array $color = [];

    #[ORM\Column(options: ['default' => 'JSON_ARRAY()'])]
    private array $images = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(name: 'supplier_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?Supplier $supplier_id = null;

    #[ORM\Column(name: 'category_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?PartCategory $category_id = null;

    #[ORM\Column(name: 'sub_category_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?PartSubCategory $sub_category_id = null;

    #[ORM\Column(name: 'promodata_id', type: Types::INTEGER, unique: true, nullable: true)]
    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?PromoDataParts $promodata_id = null;

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

    public function getPartNumber(): ?string
    {
        return $this->part_number;
    }

    public function setPartNumber(string $part_number): static
    {
        $this->part_number = $part_number;

        return $this;
    }

    public function getPartName(): ?string
    {
        return $this->part_name;
    }

    public function setPartName(string $part_name): static
    {
        $this->part_name = $part_name;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): static
    {
        $this->website = $website;

        return $this;
    }

    public function getComponentType(): ?string
    {
        return $this->component_type;
    }

    public function setComponentType(?string $component_type): static
    {
        $this->component_type = $component_type;

        return $this;
    }

    public function getSetup(): ?int
    {
        return $this->setup;
    }

    public function setSetup(int $setup): static
    {
        $this->setup = $setup;

        return $this;
    }

    public function getCosts(): array
    {
        return $this->costs;
    }

    public function setCosts(array $costs): static
    {
        $this->costs = $costs;

        return $this;
    }

    public function getCostTaxable(): ?int
    {
        return $this->cost_taxable;
    }

    public function setCostTaxable(int $cost_taxable): static
    {
        $this->cost_taxable = $cost_taxable;

        return $this;
    }

    public function getSetupTaxable(): ?int
    {
        return $this->setup_taxable;
    }

    public function setSetupTaxable(int $setup_taxable): static
    {
        $this->setup_taxable = $setup_taxable;

        return $this;
    }

    public function getColor(): array
    {
        return $this->color;
    }

    public function setColor(array $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function setImages(array $images): static
    {
        $this->images = $images;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

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

    public function getCategoryId(): ?PartCategory
    {
        return $this->category_id;
    }

    public function setCategoryId(?PartCategory $category_id): static
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getSubCategoryId(): ?PartSubCategory
    {
        return $this->sub_category_id;
    }

    public function setSubCategoryId(?PartSubCategory $sub_category_id): static
    {
        $this->sub_category_id = $sub_category_id;

        return $this;
    }

    public function getPromodataId(): ?PromoDataParts
    {
        return $this->promodata_id;
    }

    public function setPromodataId(?PromoDataParts $promodata_id): static
    {
        $this->promodata_id = $promodata_id;

        return $this;
    }
}
