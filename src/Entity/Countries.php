<?php

namespace App\Entity;

use App\Repository\CountriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'pq_countries')]
#[ORM\Entity(repositoryClass: CountriesRepository::class)]
class Countries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sortname = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $phonecode = null;

    /**
     * @var Collection<int, States>
     */
    #[ORM\OneToMany(targetEntity: States::class, mappedBy: 'country_id', orphanRemoval: true)]
    private Collection $states;

    public function __construct()
    {
        $this->states = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSortname(): ?string
    {
        return $this->sortname;
    }

    public function setSortname(string $sortname): static
    {
        $this->sortname = $sortname;

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

    public function getPhonecode(): ?int
    {
        return $this->phonecode;
    }

    public function setPhonecode(int $phonecode): static
    {
        $this->phonecode = $phonecode;

        return $this;
    }

    /**
     * @return Collection<int, States>
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    public function addState(States $state): static
    {
        if (!$this->states->contains($state)) {
            $this->states->add($state);
            $state->setCountryId($this);
        }

        return $this;
    }

    public function removeState(States $state): static
    {
        if ($this->states->removeElement($state)) {
            // set the owning side to null (unless already changed)
            if ($state->getCountryId() === $this) {
                $state->setCountryId(null);
            }
        }

        return $this;
    }
}
