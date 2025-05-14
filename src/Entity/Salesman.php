<?php

namespace App\Entity;

use App\Repository\SalesmanRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SalesmanRepository::class)]
class Salesman
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'salesmen')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $initial = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $address1 = null;

    #[ORM\Column]
    private ?int $country_id = null;

    #[ORM\Column]
    private ?int $state_id = null;

    #[ORM\Column]
    private ?int $city_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(length: 255)]
    private ?string $from_date = null;

    #[ORM\Column(length: 255)]
    private ?string $to_date = null;

    #[ORM\Column]
    private ?float $commission_rate = null;

    #[ORM\Column(length: 255)]
    private ?string $position = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_quote_heading = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $date_quote_ending = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_image = null;

    #[ORM\Column]
    private ?bool $is_active = null;

    #[ORM\Column(length: 15, nullable: true)]
    private ?string $mobile_number = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email_id = null;

    /**
     * @var Collection<int, Quotes>
     */
    #[ORM\OneToMany(targetEntity: Quotes::class, mappedBy: 'salesperson')]
    private Collection $quotes;

    public function __construct()
    {
        $this->quotes = new ArrayCollection();
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

    public function getInitial(): ?string
    {
        return $this->initial;
    }

    public function setInitial(string $initial): static
    {
        $this->initial = $initial;

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

    public function getAddress1(): ?array
    {
        return $this->address1;
    }

    public function setAddress1(?array $address1): static
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    public function setCountryId(int $country_id): static
    {
        $this->country_id = $country_id;

        return $this;
    }

    public function getStateId(): ?int
    {
        return $this->state_id;
    }

    public function setStateId(int $state_id): static
    {
        $this->state_id = $state_id;

        return $this;
    }

    public function getCityId(): ?int
    {
        return $this->city_id;
    }

    public function setCityId(int $city_id): static
    {
        $this->city_id = $city_id;

        return $this;
    }

    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    public function setPostcode(?string $postcode): static
    {
        $this->postcode = $postcode;

        return $this;
    }

    public function getFromDate(): ?string
    {
        return $this->from_date;
    }

    public function setFromDate(string $from_date): static
    {
        $this->from_date = $from_date;

        return $this;
    }

    public function getToDate(): ?string
    {
        return $this->to_date;
    }

    public function setToDate(string $to_date): static
    {
        $this->to_date = $to_date;

        return $this;
    }

    public function getCommissionRate(): ?float
    {
        return $this->commission_rate;
    }

    public function setCommissionRate(float $commission_rate): static
    {
        $this->commission_rate = $commission_rate;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getDateQuoteHeading(): ?string
    {
        return $this->date_quote_heading;
    }

    public function setDateQuoteHeading(?string $date_quote_heading): static
    {
        $this->date_quote_heading = $date_quote_heading;

        return $this;
    }

    public function getDateQuoteEnding(): ?string
    {
        return $this->date_quote_ending;
    }

    public function setDateQuoteEnding(?string $date_quote_ending): static
    {
        $this->date_quote_ending = $date_quote_ending;

        return $this;
    }

    public function getProfileImage(): ?string
    {
        return $this->profile_image;
    }

    public function setProfileImage(?string $profile_image): static
    {
        $this->profile_image = $profile_image;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobile_number;
    }

    public function setMobileNumber(?string $mobile_number): static
    {
        $this->mobile_number = $mobile_number;

        return $this;
    }

    public function getEmailId(): ?string
    {
        return $this->email_id;
    }

    public function setEmailId(?string $email_id): static
    {
        $this->email_id = $email_id;

        return $this;
    }

    /**
     * @return Collection<int, Quotes>
     */
    public function getQuotes(): Collection
    {
        return $this->quotes;
    }

    public function addQuote(Quotes $quote): static
    {
        if (!$this->quotes->contains($quote)) {
            $this->quotes->add($quote);
            $quote->setSalesperson($this);
        }

        return $this;
    }

    public function removeQuote(Quotes $quote): static
    {
        if ($this->quotes->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getSalesperson() === $this) {
                $quote->setSalesperson(null);
            }
        }

        return $this;
    }
}
