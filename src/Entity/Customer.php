<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use App\Type\YesNo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $parent_id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'customers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $salutation = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

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
    private ?string $post_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mobile = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $profile_image = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company_note = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address11 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address21 = null;

    #[ORM\Column(name: 'country_id1', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?Countries $country_id1 = null;

    #[ORM\Column(name: 'state_id1', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?States $state_id1 = null;

    #[ORM\Column(name: 'city_id1', type: Types::INTEGER, nullable: true)]
    #[ORM\ManyToOne]
    private ?Cities $city_id1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $post_code1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $company_website = null;

    #[ORM\Column(name: 'xeroKey', length: 255, nullable: true)]
    private ?string $xeroKey = null;

    #[ORM\Column(enumType: YesNo::class)]
    private ?YesNo $delete_flag = null;

    /**
     * @var Collection<int, CustomerBusinessSource>
     */
    #[ORM\OneToMany(targetEntity: CustomerBusinessSource::class, mappedBy: 'customer_id')]
    private Collection $customerBusinessSources;

    /**
     * @var Collection<int, JobTracking>
     */
    #[ORM\OneToMany(targetEntity: JobTracking::class, mappedBy: 'quote_customer')]
    private Collection $jobs;

    public function __construct()
    {
        $this->customerBusinessSources = new ArrayCollection();
        $this->jobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): static
    {
        $this->parent_id = $parent_id;

        return $this;
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

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getSalutation(): ?string
    {
        return $this->salutation;
    }

    public function setSalutation(?string $salutation): static
    {
        $this->salutation = $salutation;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

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

    public function getPostCode(): ?string
    {
        return $this->post_code;
    }

    public function setPostCode(?string $post_code): static
    {
        $this->post_code = $post_code;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getCompanyNote(): ?string
    {
        return $this->company_note;
    }

    public function setCompanyNote(?string $company_note): static
    {
        $this->company_note = $company_note;

        return $this;
    }

    public function getAddress11(): ?string
    {
        return $this->address11;
    }

    public function setAddress11(?string $address11): static
    {
        $this->address11 = $address11;

        return $this;
    }

    public function getAddress21(): ?string
    {
        return $this->address21;
    }

    public function setAddress21(?string $address21): static
    {
        $this->address21 = $address21;

        return $this;
    }

    public function getCountryId1(): ?Countries
    {
        return $this->country_id1;
    }

    public function setCountryId1(?Countries $country_id1): static
    {
        $this->country_id1 = $country_id1;

        return $this;
    }

    public function getStateId1(): ?States
    {
        return $this->state_id1;
    }

    public function setStateId1(?States $state_id1): static
    {
        $this->state_id1 = $state_id1;

        return $this;
    }

    public function getCityId1(): ?Cities
    {
        return $this->city_id1;
    }

    public function setCityId1(?Cities $city_id1): static
    {
        $this->city_id1 = $city_id1;

        return $this;
    }

    public function getPostCode1(): ?string
    {
        return $this->post_code1;
    }

    public function setPostCode1(?string $post_code1): static
    {
        $this->post_code1 = $post_code1;

        return $this;
    }

    public function getPhone1(): ?string
    {
        return $this->phone1;
    }

    public function setPhone1(?string $phone1): static
    {
        $this->phone1 = $phone1;

        return $this;
    }

    public function getCompanyWebsite(): ?string
    {
        return $this->company_website;
    }

    public function setCompanyWebsite(?string $company_website): static
    {
        $this->company_website = $company_website;

        return $this;
    }

    public function getXeroKey(): ?string
    {
        return $this->xeroKey;
    }

    public function setXeroKey(?string $xeroKey): static
    {
        $this->xeroKey = $xeroKey;

        return $this;
    }

    public function getDeleteFlag(): ?YesNo
    {
        return $this->delete_flag;
    }

    public function setDeleteFlag(YesNo $delete_flag): static
    {
        $this->delete_flag = $delete_flag;

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
            $customerBusinessSource->setCustomerId($this);
        }

        return $this;
    }

    public function removeCustomerBusinessSource(CustomerBusinessSource $customerBusinessSource): static
    {
        if ($this->customerBusinessSources->removeElement($customerBusinessSource)) {
            // set the owning side to null (unless already changed)
            if ($customerBusinessSource->getCustomerId() === $this) {
                $customerBusinessSource->setCustomerId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, JobTracking>
     */
    public function getJobs(): Collection
    {
        return $this->jobs;
    }

    public function addJob(JobTracking $job): static
    {
        if (!$this->jobs->contains($job)) {
            $this->jobs->add($job);
            $job->setQuoteCustomer($this);
        }

        return $this;
    }

    public function removeJob(JobTracking $job): static
    {
        if ($this->jobs->removeElement($job)) {
            // set the owning side to null (unless already changed)
            if ($job->getQuoteCustomer() === $this) {
                $job->setQuoteCustomer(null);
            }
        }

        return $this;
    }
}
