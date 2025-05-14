<?php

namespace App\Entity;

use App\Repository\PartCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: PartCategoryRepository::class)]
class PartCategory
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne(inversedBy: 'partCategories')]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $promodata_id = null;

    /**
     * @var Collection<int, PartSubCategory>
     */
    #[ORM\OneToMany(targetEntity: PartSubCategory::class, mappedBy: 'parent_id')]
    private Collection $partSubCategories;

    public function __construct()
    {
        $this->partSubCategories = new ArrayCollection();
    }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPromodataId(): ?int
    {
        return $this->promodata_id;
    }

    public function setPromodataId(?int $promodata_id): static
    {
        $this->promodata_id = $promodata_id;

        return $this;
    }

    /**
     * @return Collection<int, PartSubCategory>
     */
    public function getPartSubCategories(): Collection
    {
        return $this->partSubCategories;
    }

    public function addPartSubCategory(PartSubCategory $partSubCategory): static
    {
        if (!$this->partSubCategories->contains($partSubCategory)) {
            $this->partSubCategories->add($partSubCategory);
            $partSubCategory->setParentId($this);
        }

        return $this;
    }

    public function removePartSubCategory(PartSubCategory $partSubCategory): static
    {
        if ($this->partSubCategories->removeElement($partSubCategory)) {
            // set the owning side to null (unless already changed)
            if ($partSubCategory->getParentId() === $this) {
                $partSubCategory->setParentId(null);
            }
        }

        return $this;
    }
}
