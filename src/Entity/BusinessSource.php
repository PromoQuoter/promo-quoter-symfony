<?php

namespace App\Entity;

use App\Repository\BusinessSourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BusinessSourceRepository::class)]
class BusinessSource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'businessSources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, CustomerBusinessSource>
     */
    #[ORM\OneToMany(targetEntity: CustomerBusinessSource::class, mappedBy: 'resource_id')]
    private Collection $customerBusinessSources;

    public function __construct()
    {
        $this->customerBusinessSources = new ArrayCollection();
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

    /**
     * @return Collection<int, CustomerBusinessSource>
     */
    public function getCustomerBusinessSources(): Collection
    {
        return $this->customerBusinessSources;
    }

    public function addCustomerBusinessSource(CustomerBusinessSource $customerBusinessSource): static
    {
        if (!$this->customerBusinessSources->contains($customerBusinessSource)) {
            $this->customerBusinessSources->add($customerBusinessSource);
            $customerBusinessSource->setResourceId($this);
        }

        return $this;
    }

    public function removeCustomerBusinessSource(CustomerBusinessSource $customerBusinessSource): static
    {
        if ($this->customerBusinessSources->removeElement($customerBusinessSource)) {
            // set the owning side to null (unless already changed)
            if ($customerBusinessSource->getResourceId() === $this) {
                $customerBusinessSource->setResourceId(null);
            }
        }

        return $this;
    }
}
