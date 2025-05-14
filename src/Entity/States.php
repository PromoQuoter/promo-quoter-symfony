<?php

namespace App\Entity;

use App\Repository\StatesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StatesRepository::class)]
class States
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(name: 'country_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'states')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Countries $country_id = null;

    /**
     * @var Collection<int, Cities>
     */
    #[ORM\OneToMany(targetEntity: Cities::class, mappedBy: 'state_id', orphanRemoval: true)]
    private Collection $cities;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getCountryId(): ?Countries
    {
        return $this->country_id;
    }

    public function setCountryId(?Countries $country_id): static
    {
        $this->country_id = $country_id;

        return $this;
    }

    /**
     * @return Collection<int, Cities>
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(Cities $city): static
    {
        if (!$this->cities->contains($city)) {
            $this->cities->add($city);
            $city->setStateId($this);
        }

        return $this;
    }

    public function removeCity(Cities $city): static
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getStateId() === $this) {
                $city->setStateId(null);
            }
        }

        return $this;
    }
}
