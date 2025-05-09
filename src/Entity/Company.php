<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $contact_person = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $website = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $abn_no = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address1 = null;

    #[ORM\Column(length: 255)]
    private ?string $address2 = null;

    #[ORM\ManyToOne]
    private ?Countries $country = null;

    #[ORM\ManyToOne]
    private ?States $state = null;

    #[ORM\ManyToOne]
    private ?Cities $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $post_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $xero_invoice_account_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $xero_purchase_account_code = null;

    #[ORM\Column(type: 'longtext', nullable: true)]
    private ?array $additional_addresses = null;

    /**
     * @var Collection<int, BusinessSource>
     */
    #[ORM\OneToMany(targetEntity: BusinessSource::class, mappedBy: 'company_id')]
    private Collection $businessSources;

    /**
     * @var Collection<int, CompanyInvites>
     */
    #[ORM\OneToMany(targetEntity: CompanyInvites::class, mappedBy: 'company_id')]
    private Collection $companyInvites;

    /**
     * @var Collection<int, Customer>
     */
    #[ORM\OneToMany(targetEntity: Customer::class, mappedBy: 'company_id')]
    private Collection $customers;

    /**
     * @var Collection<int, JobStatus>
     */
    #[ORM\OneToMany(targetEntity: JobStatus::class, mappedBy: 'company_id')]
    private Collection $jobStatuses;

    /**
     * @var Collection<int, JobTracking>
     */
    #[ORM\OneToMany(targetEntity: JobTracking::class, mappedBy: 'company_id')]
    private Collection $jobTrackings;

    #[ORM\OneToOne(mappedBy: 'company_id', cascade: ['persist', 'remove'])]
    private ?Options $options = null;

    /**
     * @var Collection<int, PartCategory>
     */
    #[ORM\OneToMany(targetEntity: PartCategory::class, mappedBy: 'company_id')]
    private Collection $partCategories;

    /**
     * @var Collection<int, PartXeroKey>
     */
    #[ORM\OneToMany(targetEntity: PartXeroKey::class, mappedBy: 'company_id')]
    private Collection $partXeroKeys;

    #[ORM\OneToOne(mappedBy: 'company_id', cascade: ['persist', 'remove'])]
    private ?QuoteLayoutSetting $quoteLayoutSetting = null;

    /**
     * @var Collection<int, QuoteStatus>
     */
    #[ORM\OneToMany(targetEntity: QuoteStatus::class, mappedBy: 'company_id')]
    private Collection $quoteStatuses;

    /**
     * @var Collection<int, Quotes>
     */
    #[ORM\OneToMany(targetEntity: Quotes::class, mappedBy: 'company_id')]
    private Collection $quotes;

    /**
     * @var Collection<int, Salesman>
     */
    #[ORM\OneToMany(targetEntity: Salesman::class, mappedBy: 'company_id')]
    private Collection $salesmen;

    /**
     * @var Collection<int, ShippingType>
     */
    #[ORM\OneToMany(targetEntity: ShippingType::class, mappedBy: 'company_id')]
    private Collection $shippingTypes;

    /**
     * @var Collection<int, Supplier>
     */
    #[ORM\OneToMany(targetEntity: Supplier::class, mappedBy: 'company_id')]
    private Collection $suppliers;

    public function __construct()
    {
        $this->businessSources = new ArrayCollection();
        $this->companyInvites = new ArrayCollection();
        $this->customers = new ArrayCollection();
        $this->jobStatuses = new ArrayCollection();
        $this->jobTrackings = new ArrayCollection();
        $this->partCategories = new ArrayCollection();
        $this->partXeroKeys = new ArrayCollection();
        $this->quoteStatuses = new ArrayCollection();
        $this->quotes = new ArrayCollection();
        $this->salesmen = new ArrayCollection();
        $this->shippingTypes = new ArrayCollection();
        $this->suppliers = new ArrayCollection();
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

    public function getContactPerson(): ?string
    {
        return $this->contact_person;
    }

    public function setContactPerson(string $contact_person): static
    {
        $this->contact_person = $contact_person;

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

    public function getAbnNo(): ?string
    {
        return $this->abn_no;
    }

    public function setAbnNo(?string $abn_no): static
    {
        $this->abn_no = $abn_no;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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

    public function getCountry(): ?Countries
    {
        return $this->country;
    }

    public function setCountry(?Countries $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getState(): ?States
    {
        return $this->state;
    }

    public function setState(?States $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPostCode(): ?string
    {
        return $this->post_code;
    }

    public function setPostCode(?string $post_code): static
    {
        $this->post_code = $post_code;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getXeroInvoiceAccountCode(): ?string
    {
        return $this->xero_invoice_account_code;
    }

    public function setXeroInvoiceAccountCode(?string $xero_invoice_account_code): static
    {
        $this->xero_invoice_account_code = $xero_invoice_account_code;

        return $this;
    }

    public function getXeroPurchaseAccountCode(): ?string
    {
        return $this->xero_purchase_account_code;
    }

    public function setXeroPurchaseAccountCode(?string $xero_purchase_account_code): static
    {
        $this->xero_purchase_account_code = $xero_purchase_account_code;

        return $this;
    }

    public function getAdditionalAddresses(): ?array
    {
        return $this->additional_addresses;
    }

    public function setAdditionalAddresses(?array $additional_addresses): static
    {
        $this->additional_addresses = $additional_addresses;

        return $this;
    }

    /**
     * @return Collection<int, BusinessSource>
     */
    public function getBusinessSources(): Collection
    {
        return $this->businessSources;
    }

    public function addBusinessSource(BusinessSource $businessSource): static
    {
        if (!$this->businessSources->contains($businessSource)) {
            $this->businessSources->add($businessSource);
            $businessSource->setCompanyId($this);
        }

        return $this;
    }

    public function removeBusinessSource(BusinessSource $businessSource): static
    {
        if ($this->businessSources->removeElement($businessSource)) {
            // set the owning side to null (unless already changed)
            if ($businessSource->getCompanyId() === $this) {
                $businessSource->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CompanyInvites>
     */
    public function getCompanyInvites(): Collection
    {
        return $this->companyInvites;
    }

    public function addCompanyInvite(CompanyInvites $companyInvite): static
    {
        if (!$this->companyInvites->contains($companyInvite)) {
            $this->companyInvites->add($companyInvite);
            $companyInvite->setCompanyId($this);
        }

        return $this;
    }

    public function removeCompanyInvite(CompanyInvites $companyInvite): static
    {
        if ($this->companyInvites->removeElement($companyInvite)) {
            // set the owning side to null (unless already changed)
            if ($companyInvite->getCompanyId() === $this) {
                $companyInvite->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Customer>
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customer $customer): static
    {
        if (!$this->customers->contains($customer)) {
            $this->customers->add($customer);
            $customer->setCompanyId($this);
        }

        return $this;
    }

    public function removeCustomer(Customer $customer): static
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getCompanyId() === $this) {
                $customer->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JobStatus>
     */
    public function getJobStatuses(): Collection
    {
        return $this->jobStatuses;
    }

    public function addJobStatus(JobStatus $jobStatus): static
    {
        if (!$this->jobStatuses->contains($jobStatus)) {
            $this->jobStatuses->add($jobStatus);
            $jobStatus->setCompanyId($this);
        }

        return $this;
    }

    public function removeJobStatus(JobStatus $jobStatus): static
    {
        if ($this->jobStatuses->removeElement($jobStatus)) {
            // set the owning side to null (unless already changed)
            if ($jobStatus->getCompanyId() === $this) {
                $jobStatus->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JobTracking>
     */
    public function getJobTrackings(): Collection
    {
        return $this->jobTrackings;
    }

    public function addJobTracking(JobTracking $jobTracking): static
    {
        if (!$this->jobTrackings->contains($jobTracking)) {
            $this->jobTrackings->add($jobTracking);
            $jobTracking->setCompanyId($this);
        }

        return $this;
    }

    public function removeJobTracking(JobTracking $jobTracking): static
    {
        if ($this->jobTrackings->removeElement($jobTracking)) {
            // set the owning side to null (unless already changed)
            if ($jobTracking->getCompanyId() === $this) {
                $jobTracking->setCompanyId(null);
            }
        }

        return $this;
    }

    public function getOptions(): ?Options
    {
        return $this->options;
    }

    public function setOptions(Options $options): static
    {
        // set the owning side of the relation if necessary
        if ($options->getCompanyId() !== $this) {
            $options->setCompanyId($this);
        }

        $this->options = $options;

        return $this;
    }

    /**
     * @return Collection<int, PartCategory>
     */
    public function getPartCategories(): Collection
    {
        return $this->partCategories;
    }

    public function addPartCategory(PartCategory $partCategory): static
    {
        if (!$this->partCategories->contains($partCategory)) {
            $this->partCategories->add($partCategory);
            $partCategory->setCompanyId($this);
        }

        return $this;
    }

    public function removePartCategory(PartCategory $partCategory): static
    {
        if ($this->partCategories->removeElement($partCategory)) {
            // set the owning side to null (unless already changed)
            if ($partCategory->getCompanyId() === $this) {
                $partCategory->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PartXeroKey>
     */
    public function getPartXeroKeys(): Collection
    {
        return $this->partXeroKeys;
    }

    public function addPartXeroKey(PartXeroKey $partXeroKey): static
    {
        if (!$this->partXeroKeys->contains($partXeroKey)) {
            $this->partXeroKeys->add($partXeroKey);
            $partXeroKey->setCompanyId($this);
        }

        return $this;
    }

    public function removePartXeroKey(PartXeroKey $partXeroKey): static
    {
        if ($this->partXeroKeys->removeElement($partXeroKey)) {
            // set the owning side to null (unless already changed)
            if ($partXeroKey->getCompanyId() === $this) {
                $partXeroKey->setCompanyId(null);
            }
        }

        return $this;
    }

    public function getQuoteLayoutSetting(): ?QuoteLayoutSetting
    {
        return $this->quoteLayoutSetting;
    }

    public function setQuoteLayoutSetting(QuoteLayoutSetting $quoteLayoutSetting): static
    {
        // set the owning side of the relation if necessary
        if ($quoteLayoutSetting->getCompanyId() !== $this) {
            $quoteLayoutSetting->setCompanyId($this);
        }

        $this->quoteLayoutSetting = $quoteLayoutSetting;

        return $this;
    }

    /**
     * @return Collection<int, QuoteStatus>
     */
    public function getQuoteStatuses(): Collection
    {
        return $this->quoteStatuses;
    }

    public function addQuoteStatus(QuoteStatus $quoteStatus): static
    {
        if (!$this->quoteStatuses->contains($quoteStatus)) {
            $this->quoteStatuses->add($quoteStatus);
            $quoteStatus->setCompanyId($this);
        }

        return $this;
    }

    public function removeQuoteStatus(QuoteStatus $quoteStatus): static
    {
        if ($this->quoteStatuses->removeElement($quoteStatus)) {
            // set the owning side to null (unless already changed)
            if ($quoteStatus->getCompanyId() === $this) {
                $quoteStatus->setCompanyId(null);
            }
        }

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
            $quote->setCompanyId($this);
        }

        return $this;
    }

    public function removeQuote(Quotes $quote): static
    {
        if ($this->quotes->removeElement($quote)) {
            // set the owning side to null (unless already changed)
            if ($quote->getCompanyId() === $this) {
                $quote->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Salesman>
     */
    public function getSalesmen(): Collection
    {
        return $this->salesmen;
    }

    public function addSalesman(Salesman $salesman): static
    {
        if (!$this->salesmen->contains($salesman)) {
            $this->salesmen->add($salesman);
            $salesman->setCompanyId($this);
        }

        return $this;
    }

    public function removeSalesman(Salesman $salesman): static
    {
        if ($this->salesmen->removeElement($salesman)) {
            // set the owning side to null (unless already changed)
            if ($salesman->getCompanyId() === $this) {
                $salesman->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ShippingType>
     */
    public function getShippingTypes(): Collection
    {
        return $this->shippingTypes;
    }

    public function addShippingType(ShippingType $shippingType): static
    {
        if (!$this->shippingTypes->contains($shippingType)) {
            $this->shippingTypes->add($shippingType);
            $shippingType->setCompanyId($this);
        }

        return $this;
    }

    public function removeShippingType(ShippingType $shippingType): static
    {
        if ($this->shippingTypes->removeElement($shippingType)) {
            // set the owning side to null (unless already changed)
            if ($shippingType->getCompanyId() === $this) {
                $shippingType->setCompanyId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Supplier>
     */
    public function getSuppliers(): Collection
    {
        return $this->suppliers;
    }

    public function addSupplier(Supplier $supplier): static
    {
        if (!$this->suppliers->contains($supplier)) {
            $this->suppliers->add($supplier);
            $supplier->setCompanyId($this);
        }

        return $this;
    }

    public function removeSupplier(Supplier $supplier): static
    {
        if ($this->suppliers->removeElement($supplier)) {
            // set the owning side to null (unless already changed)
            if ($supplier->getCompanyId() === $this) {
                $supplier->setCompanyId(null);
            }
        }

        return $this;
    }
}
