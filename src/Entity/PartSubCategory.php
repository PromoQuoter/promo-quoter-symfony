<?php

namespace App\Entity;

use App\Repository\PartSubCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PartSubCategoryRepository::class)]
class PartSubCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'partSubCategories')]
    private ?PartCategory $parent_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $promodata_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentId(): ?PartCategory
    {
        return $this->parent_id;
    }

    public function setParentId(?PartCategory $parent_id): static
    {
        $this->parent_id = $parent_id;

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

    public function getPromodataId(): ?string
    {
        return $this->promodata_id;
    }

    public function setPromodataId(string $promodata_id): static
    {
        $this->promodata_id = $promodata_id;

        return $this;
    }
}
