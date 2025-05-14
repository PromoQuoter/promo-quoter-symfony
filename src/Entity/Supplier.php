<?php

namespace App\Entity;

use App\Repository\SupplierRepository;
use App\Type\YesNo;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
class Supplier
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'suppliers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $contact = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mobile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address2 = null;

    #[ORM\Column(name: 'country_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?Countries $country_id = null;

    #[ORM\Column(name: 'state_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?States $state_id = null;

    #[ORM\Column(name: 'city_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?Cities $city_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postcode = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note = null;

    #[ORM\Column(name: 'shipping_type', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?ShippingType $shipping_type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $trading_terms = null;

    #[ORM\Column(name: 'promodata_id', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?PromoDataSuppliers $promodata_id = null;

    #[ORM\Column]
    private ?bool $modified = null;

    #[ORM\Column(name: 'isActivesSupplier', enumType: YesNo::class)]
    private ?YesNo $isActiveSupplier = null;

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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(?string $mobile): static
    {
        $this->mobile = $mobile;

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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): static
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(string $address2): static
    {
        $this->address2 = $address2;

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

    public function getStateId(): ?States
    {
        return $this->state_id;
    }

    public function setStateId(?States $state_id): static
    {
        $this->state_id = $state_id;

        return $this;
    }

    public function getCityId(): ?Cities
    {
        return $this->city_id;
    }

    public function setCityId(?Cities $city_id): static
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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getShippingType(): ?ShippingType
    {
        return $this->shipping_type;
    }

    public function setShippingType(?ShippingType $shipping_type): static
    {
        $this->shipping_type = $shipping_type;

        return $this;
    }

    public function getTradingTerms(): ?string
    {
        return $this->trading_terms;
    }

    public function setTradingTerms(?string $trading_terms): static
    {
        $this->trading_terms = $trading_terms;

        return $this;
    }

    public function getPromodataId(): ?PromoDataSuppliers
    {
        return $this->promodata_id;
    }

    public function setPromodataId(?PromoDataSuppliers $promodata_id): static
    {
        $this->promodata_id = $promodata_id;

        return $this;
    }

    public function isModified(): ?bool
    {
        return $this->modified;
    }

    public function setModified(bool $modified): static
    {
        $this->modified = $modified;

        return $this;
    }

    public function getIsActiveSupplier(): ?YesNo
    {
        return $this->isActiveSupplier;
    }

    public function setIsActiveSupplier(YesNo $isActiveSupplier): static
    {
        $this->isActiveSupplier = $isActiveSupplier;

        return $this;
    }
}
