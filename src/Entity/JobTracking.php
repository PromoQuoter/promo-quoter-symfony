<?php

namespace App\Entity;

use App\Repository\JobTrackingRepository;
use App\Type\YesNoShort;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: JobTrackingRepository::class)]
class JobTracking
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'jobTrackings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(name: 'quotes_id', type: Types::INTEGER)]
    #[ORM\OneToOne(inversedBy: 'jobTracking', cascade: ['persist', 'remove'])]
    private ?Quotes $quotes_id = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_no = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_title = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_company = null;

    #[ORM\Column(name: 'quote_customer', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'jobs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $quote_customer = null;

    #[ORM\Column(name: 'salesperson', type: Types::INTEGER)]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salesman $salesperson = null;

    #[ORM\Column]
    private ?float $freight = null;

    #[ORM\Column]
    private ?float $adjust_profit = null;

    #[ORM\Column]
    private ?float $total_part = null;

    #[ORM\Column]
    private ?float $profit_amt = null;

    #[ORM\Column]
    private ?float $cost_amt = null;

    #[ORM\Column]
    private ?float $profit_per = null;

    #[ORM\Column]
    private ?float $total_10 = null;

    #[ORM\Column]
    private ?float $total_w_tax = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $job_date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $job_note = null;

    #[ORM\Column(name: 'job_status', type: Types::INTEGER)]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?JobStatus $job_status = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cust_p_o = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $job_start_date = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?DateTimeImmutable $job_end_date = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $xero_invoice = null;

    #[ORM\Column(length: 1)]
    private ?string $call_back_complete = null;

    #[ORM\Column(length: 1)]
    private ?string $urgent = null;

    #[ORM\Column(length: 1)]
    private ?string $job_billed = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tracking_no = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tracking_carrier = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $delete_flag = null;

    /**
     * @var Collection<int, JobTrackingPartArtwork>
     */
    #[ORM\OneToMany(targetEntity: JobTrackingPartArtwork::class, mappedBy: 'job_id')]
    private Collection $artwork;

    public function __construct()
    {
        $this->artwork = new ArrayCollection();
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

    public function getQuotesId(): ?Quotes
    {
        return $this->quotes_id;
    }

    public function setQuotesId(?Quotes $quotes_id): static
    {
        $this->quotes_id = $quotes_id;

        return $this;
    }

    public function getQuoteNo(): ?string
    {
        return $this->quote_no;
    }

    public function setQuoteNo(string $quote_no): static
    {
        $this->quote_no = $quote_no;

        return $this;
    }

    public function getQuoteTitle(): ?string
    {
        return $this->quote_title;
    }

    public function setQuoteTitle(string $quote_title): static
    {
        $this->quote_title = $quote_title;

        return $this;
    }

    public function getQuoteCompany(): ?string
    {
        return $this->quote_company;
    }

    public function setQuoteCompany(string $quote_company): static
    {
        $this->quote_company = $quote_company;

        return $this;
    }

    public function getQuoteCustomer(): ?Customer
    {
        return $this->quote_customer;
    }

    public function setQuoteCustomer(?Customer $quote_customer): static
    {
        $this->quote_customer = $quote_customer;

        return $this;
    }

    public function getSalesperson(): ?Salesman
    {
        return $this->salesperson;
    }

    public function setSalesperson(?Salesman $salesperson): static
    {
        $this->salesperson = $salesperson;

        return $this;
    }

    public function getFreight(): ?float
    {
        return $this->freight;
    }

    public function setFreight(float $freight): static
    {
        $this->freight = $freight;

        return $this;
    }

    public function getAdjustProfit(): ?float
    {
        return $this->adjust_profit;
    }

    public function setAdjustProfit(float $adjust_profit): static
    {
        $this->adjust_profit = $adjust_profit;

        return $this;
    }

    public function getTotalPart(): ?float
    {
        return $this->total_part;
    }

    public function setTotalPart(float $total_part): static
    {
        $this->total_part = $total_part;

        return $this;
    }

    public function getProfitAmt(): ?float
    {
        return $this->profit_amt;
    }

    public function setProfitAmt(float $profit_amt): static
    {
        $this->profit_amt = $profit_amt;

        return $this;
    }

    public function getCostAmt(): ?float
    {
        return $this->cost_amt;
    }

    public function setCostAmt(float $cost_amt): static
    {
        $this->cost_amt = $cost_amt;

        return $this;
    }

    public function getProfitPer(): ?float
    {
        return $this->profit_per;
    }

    public function setProfitPer(float $profit_per): static
    {
        $this->profit_per = $profit_per;

        return $this;
    }

    public function getTotal10(): ?float
    {
        return $this->total_10;
    }

    public function setTotal10(float $total_10): static
    {
        $this->total_10 = $total_10;

        return $this;
    }

    public function getTotalWTax(): ?float
    {
        return $this->total_w_tax;
    }

    public function setTotalWTax(float $total_w_tax): static
    {
        $this->total_w_tax = $total_w_tax;

        return $this;
    }

    public function getJobDate(): ?DateTimeImmutable
    {
        return $this->job_date;
    }

    public function setJobDate(DateTimeImmutable $job_date): static
    {
        $this->job_date = $job_date;

        return $this;
    }

    public function getJobNote(): ?string
    {
        return $this->job_note;
    }

    public function setJobNote(?string $job_note): static
    {
        $this->job_note = $job_note;

        return $this;
    }

    public function getJobStatus(): ?JobStatus
    {
        return $this->job_status;
    }

    public function setJobStatus(?JobStatus $job_status): static
    {
        $this->job_status = $job_status;

        return $this;
    }

    public function getCustPO(): ?string
    {
        return $this->cust_p_o;
    }

    public function setCustPO(?string $cust_p_o): static
    {
        $this->cust_p_o = $cust_p_o;

        return $this;
    }

    public function getJobStartDate(): ?\DateTime
    {
        return $this->job_start_date;
    }

    public function setJobStartDate(DateTimeImmutable $job_start_date): static
    {
        $this->job_start_date = $job_start_date;

        return $this;
    }

    public function getJobEndDate(): ?\DateTime
    {
        return $this->job_end_date;
    }

    public function setJobEndDate(DateTimeImmutable $job_end_date): static
    {
        $this->job_end_date = $job_end_date;

        return $this;
    }

    public function getXeroInvoice(): ?string
    {
        return $this->xero_invoice;
    }

    public function setXeroInvoice(?string $xero_invoice): static
    {
        $this->xero_invoice = $xero_invoice;

        return $this;
    }

    public function getCallBackComplete(): ?string
    {
        return $this->call_back_complete;
    }

    public function setCallBackComplete(string $call_back_complete): static
    {
        $this->call_back_complete = $call_back_complete;

        return $this;
    }

    public function getUrgent(): ?string
    {
        return $this->urgent;
    }

    public function setUrgent(string $urgent): static
    {
        $this->urgent = $urgent;

        return $this;
    }

    public function getJobBilled(): ?string
    {
        return $this->job_billed;
    }

    public function setJobBilled(string $job_billed): static
    {
        $this->job_billed = $job_billed;

        return $this;
    }

    public function getTrackingNo(): ?string
    {
        return $this->tracking_no;
    }

    public function setTrackingNo(?string $tracking_no): static
    {
        $this->tracking_no = $tracking_no;

        return $this;
    }

    public function getTrackingCarrier(): ?string
    {
        return $this->tracking_carrier;
    }

    public function setTrackingCarrier(?string $tracking_carrier): static
    {
        $this->tracking_carrier = $tracking_carrier;

        return $this;
    }

    public function getDeleteFlag(): ?YesNoShort
    {
        return $this->delete_flag;
    }

    public function setDeleteFlag(YesNoShort $delete_flag): static
    {
        $this->delete_flag = $delete_flag;

        return $this;
    }

    /**
     * @return Collection<int, JobTrackingPartArtwork>
     */
    public function getArtwork(): Collection
    {
        return $this->artwork;
    }

    public function addArtwork(JobTrackingPartArtwork $artwork): static
    {
        if (!$this->artwork->contains($artwork)) {
            $this->artwork->add($artwork);
            $artwork->setJobId($this);
        }

        return $this;
    }

    public function removeArtwork(JobTrackingPartArtwork $artwork): static
    {
        if ($this->artwork->removeElement($artwork)) {
            // set the owning side to null (unless already changed)
            if ($artwork->getJobId() === $this) {
                $artwork->setJobId(null);
            }
        }

        return $this;
    }
}
