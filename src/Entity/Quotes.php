<?php

namespace App\Entity;

use App\Repository\QuotesRepository;
use App\Type\QuoteStatusAccepted;
use App\Type\YesNo;
use App\Type\YesNoShort;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: QuotesRepository::class)]
class Quotes
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $unique_id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'quotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column]
    private ?int $quote_no = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_no_format = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_company = null;

    #[ORM\Column(name: 'quote_customer', type: Types::INTEGER)]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $quote_customer = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_title = null;

    #[ORM\Column(name: 'quote_status', type: Types::INTEGER)]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuoteStatus $quote_status = null;

    #[ORM\Column(name: 'quotes_email_tracker', type: Types::INTEGER)]
    #[ORM\OneToOne(mappedBy: 'quotes_id', cascade: ['persist', 'remove'])]
    private ?QuotesEmailTracker $quotesEmailTracker = null;

    /**
     * @var Collection<int, QuoteLineItems>
     */
    #[ORM\OneToMany(targetEntity: QuoteLineItems::class, mappedBy: 'quote_id')]
    private Collection $quoteLineItems;

    #[ORM\Column(name: 'salesperson', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'quotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Salesman $salesperson = null;

    #[ORM\Column]
    private ?int $tax = null;

    #[ORM\Column]
    private ?int $freight = null;

    #[ORM\Column]
    private ?float $total_part = null;

    #[ORM\Column]
    private ?float $profit_amt = null;

    #[ORM\Column]
    private ?float $cost_amt = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $note = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $internal_note = null;

    #[ORM\Column]
    private ?float $profit_per = null;

    #[ORM\Column]
    private ?float $total_10 = null;

    #[ORM\Column]
    private ?float $total_w_tax = null;

    #[ORM\Column(enumType: YesNo::class)]
    private ?YesNo $xero_api = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invoice_xero_id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $invoice_xero_no = null;

    #[ORM\Column(name: 'invoice_Date', type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $invoice_Date = null;

    #[ORM\Column(name: 'AmountDue', length: 255, nullable: true)]
    private ?string $AmountDue = null;

    #[ORM\Column(enumType: YesNoShort::class)]
    private ?YesNoShort $delete_flag = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $due_date = null;

    #[ORM\Column]
    private ?bool $email_sent = null;

    #[ORM\Column(nullable: true, enumType: QuoteStatusAccepted::class)]
    private ?QuoteStatusAccepted $quote_status_accepted = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $quote_comment = null;

    #[ORM\OneToOne(mappedBy: 'quotes_id', cascade: ['persist', 'remove'])]
    private ?JobTracking $jobTracking = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $quote_status_time = null;

    public function __construct()
    {
        $this->quoteLineItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUniqueId(): ?string
    {
        return $this->unique_id;
    }

    public function setUniqueId(string $unique_id): static
    {
        $this->unique_id = $unique_id;

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

    public function getQuoteNo(): ?int
    {
        return $this->quote_no;
    }

    public function setQuoteNo(int $quote_no): static
    {
        $this->quote_no = $quote_no;

        return $this;
    }

    public function getQuoteNoFormat(): ?string
    {
        return $this->quote_no_format;
    }

    public function setQuoteNoFormat(string $quote_no_format): static
    {
        $this->quote_no_format = $quote_no_format;

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

    public function getQuoteTitle(): ?string
    {
        return $this->quote_title;
    }

    public function setQuoteTitle(string $quote_title): static
    {
        $this->quote_title = $quote_title;

        return $this;
    }

    public function getQuoteStatus(): ?QuoteStatus
    {
        return $this->quote_status;
    }

    public function setQuoteStatus(?QuoteStatus $quote_status): static
    {
        $this->quote_status = $quote_status;

        return $this;
    }

    public function getQuotesEmailTracker(): ?QuotesEmailTracker
    {
        return $this->quotesEmailTracker;
    }

    public function setQuotesEmailTracker(QuotesEmailTracker $quotesEmailTracker): static
    {
        // set the owning side of the relation if necessary
        if ($quotesEmailTracker->getQuotesId() !== $this) {
            $quotesEmailTracker->setQuotesId($this);
        }

        $this->quotesEmailTracker = $quotesEmailTracker;

        return $this;
    }

    /**
     * @return Collection<int, QuoteLineItems>
     */
    public function getQuoteLineItems(): Collection
    {
        return $this->quoteLineItems;
    }

    public function addQuoteLineItem(QuoteLineItems $quoteLineItem): static
    {
        if (!$this->quoteLineItems->contains($quoteLineItem)) {
            $this->quoteLineItems->add($quoteLineItem);
            $quoteLineItem->setQuoteId($this);
        }

        return $this;
    }

    public function removeQuoteLineItem(QuoteLineItems $quoteLineItem): static
    {
        if ($this->quoteLineItems->removeElement($quoteLineItem)) {
            // set the owning side to null (unless already changed)
            if ($quoteLineItem->getQuoteId() === $this) {
                $quoteLineItem->setQuoteId(null);
            }
        }

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

    public function getTax(): ?int
    {
        return $this->tax;
    }

    public function setTax(int $tax): static
    {
        $this->tax = $tax;

        return $this;
    }

    public function getFreight(): ?int
    {
        return $this->freight;
    }

    public function setFreight(int $freight): static
    {
        $this->freight = $freight;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): static
    {
        $this->note = $note;

        return $this;
    }

    public function getInternalNote(): ?string
    {
        return $this->internal_note;
    }

    public function setInternalNote(?string $internal_note): static
    {
        $this->internal_note = $internal_note;

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

    public function getXeroApi(): ?YesNo
    {
        return $this->xero_api;
    }

    public function setXeroApi(YesNo $xero_api): static
    {
        $this->xero_api = $xero_api;

        return $this;
    }

    public function getInvoiceXeroId(): ?string
    {
        return $this->invoice_xero_id;
    }

    public function setInvoiceXeroId(?string $invoice_xero_id): static
    {
        $this->invoice_xero_id = $invoice_xero_id;

        return $this;
    }

    public function getInvoiceXeroNo(): ?string
    {
        return $this->invoice_xero_no;
    }

    public function setInvoiceXeroNo(?string $invoice_xero_no): static
    {
        $this->invoice_xero_no = $invoice_xero_no;

        return $this;
    }

    public function getInvoiceDate(): ?DateTime
    {
        return $this->invoice_Date;
    }

    public function setInvoiceDate(?DateTime $invoice_Date): static
    {
        $this->invoice_Date = $invoice_Date;

        return $this;
    }

    public function getAmountDue(): ?string
    {
        return $this->AmountDue;
    }

    public function setAmountDue(?string $AmountDue): static
    {
        $this->AmountDue = $AmountDue;

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

    public function getDueDate(): ?DateTimeImmutable
    {
        return $this->due_date;
    }

    public function setDueDate(?DateTimeImmutable $due_date): static
    {
        $this->due_date = $due_date;

        return $this;
    }

    public function isEmailSent(): ?bool
    {
        return $this->email_sent;
    }

    public function setEmailSent(bool $email_sent): static
    {
        $this->email_sent = $email_sent;

        return $this;
    }

    public function getQuoteStatusAccepted(): ?QuoteStatusAccepted
    {
        return $this->quote_status_accepted;
    }

    public function setQuoteStatusAccepted(?QuoteStatusAccepted $quote_status_accepted): static
    {
        $this->quote_status_accepted = $quote_status_accepted;

        return $this;
    }

    public function getQuoteComment(): ?string
    {
        return $this->quote_comment;
    }

    public function setQuoteComment(?string $quote_comment): static
    {
        $this->quote_comment = $quote_comment;

        return $this;
    }

    public function getJobTracking(): ?JobTracking
    {
        return $this->jobTracking;
    }

    public function setJobTracking(?JobTracking $jobTracking): static
    {
        // unset the owning side of the relation if necessary
        if ($jobTracking === null && $this->jobTracking !== null) {
            $this->jobTracking->setQuotesId(null);
        }

        // set the owning side of the relation if necessary
        if ($jobTracking !== null && $jobTracking->getQuotesId() !== $this) {
            $jobTracking->setQuotesId($this);
        }

        $this->jobTracking = $jobTracking;

        return $this;
    }

    public function getQuoteStatusTime(): ?DateTimeImmutable
    {
        return $this->quote_status_time;
    }

    public function setQuoteStatusTime(?DateTimeImmutable $quote_status_time): static
    {
        $this->quote_status_time = $quote_status_time;

        return $this;
    }
}
