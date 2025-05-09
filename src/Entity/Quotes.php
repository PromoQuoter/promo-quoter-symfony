<?php

namespace App\Entity;

use App\Repository\QuotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuotesRepository::class)]
class Quotes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $unique_id = null;

    #[ORM\ManyToOne(inversedBy: 'quotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column]
    private ?int $quote_no = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_no_format = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_company = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $quote_customer = null;

    #[ORM\Column(length: 255)]
    private ?string $quote_title = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuoteStatus $quote_status = null;

    #[ORM\OneToOne(mappedBy: 'quotes_id', cascade: ['persist', 'remove'])]
    private ?QuotesEmailTracker $quotesEmailTracker = null;

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
}
