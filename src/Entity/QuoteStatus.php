<?php

namespace App\Entity;

use App\Repository\QuoteStatusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuoteStatusRepository::class)]
class QuoteStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'quoteStatuses')]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $order_no = null;

    #[ORM\Column]
    private ?bool $default_when_add_new_quotes = null;

    #[ORM\Column]
    private ?bool $default_when_creating_job_quote = null;

    #[ORM\Column]
    private ?bool $default_when_job_from_quote_id_completed = null;

    #[ORM\Column]
    private ?bool $default_when_ordering_p_o_form = null;

    #[ORM\Column]
    private ?bool $default_when_invoice_is_complete = null;

    #[ORM\Column]
    private ?bool $default_when_quote_has_been_sent = null;

    #[ORM\Column]
    private ?bool $default_when_quote_not_proceeding = null;

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

    public function getOrderNo(): ?int
    {
        return $this->order_no;
    }

    public function setOrderNo(int $order_no): static
    {
        $this->order_no = $order_no;

        return $this;
    }

    public function isDefaultWhenAddNewQuotes(): ?bool
    {
        return $this->default_when_add_new_quotes;
    }

    public function setDefaultWhenAddNewQuotes(bool $default_when_add_new_quotes): static
    {
        $this->default_when_add_new_quotes = $default_when_add_new_quotes;

        return $this;
    }

    public function isDefaultWhenCreatingJobQuote(): ?bool
    {
        return $this->default_when_creating_job_quote;
    }

    public function setDefaultWhenCreatingJobQuote(bool $default_when_creating_job_quote): static
    {
        $this->default_when_creating_job_quote = $default_when_creating_job_quote;

        return $this;
    }

    public function isDefaultWhenJobFromQuoteIdCompleted(): ?bool
    {
        return $this->default_when_job_from_quote_id_completed;
    }

    public function setDefaultWhenJobFromQuoteIdCompleted(bool $default_when_job_from_quote_id_completed): static
    {
        $this->default_when_job_from_quote_id_completed = $default_when_job_from_quote_id_completed;

        return $this;
    }

    public function isDefaultWhenOrderingPOForm(): ?bool
    {
        return $this->default_when_ordering_p_o_form;
    }

    public function setDefaultWhenOrderingPOForm(bool $default_when_ordering_p_o_form): static
    {
        $this->default_when_ordering_p_o_form = $default_when_ordering_p_o_form;

        return $this;
    }

    public function isDefaultWhenInvoiceIsComplete(): ?bool
    {
        return $this->default_when_invoice_is_complete;
    }

    public function setDefaultWhenInvoiceIsComplete(bool $default_when_invoice_is_complete): static
    {
        $this->default_when_invoice_is_complete = $default_when_invoice_is_complete;

        return $this;
    }

    public function isDefaultWhenQuoteHasBeenSent(): ?bool
    {
        return $this->default_when_quote_has_been_sent;
    }

    public function setDefaultWhenQuoteHasBeenSent(bool $default_when_quote_has_been_sent): static
    {
        $this->default_when_quote_has_been_sent = $default_when_quote_has_been_sent;

        return $this;
    }

    public function isDefaultWhenQuoteNotProceeding(): ?bool
    {
        return $this->default_when_quote_not_proceeding;
    }

    public function setDefaultWhenQuoteNotProceeding(bool $default_when_quote_not_proceeding): static
    {
        $this->default_when_quote_not_proceeding = $default_when_quote_not_proceeding;

        return $this;
    }
}
