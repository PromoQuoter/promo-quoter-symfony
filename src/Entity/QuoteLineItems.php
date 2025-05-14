<?php

namespace App\Entity;

use App\Repository\QuoteLineItemsRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuoteLineItemsRepository::class)]
class QuoteLineItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'quote_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'quoteLineItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quotes $quote_id = null;

    #[ORM\Column(name: 'part_id', type: Types::INTEGER)]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?PartDatabase $part_id = null;

    #[ORM\Column]
    private ?int $line_item_index = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $details = null;

    #[ORM\Column(length: 255)]
    private ?string $hero_image_url = null;

    #[ORM\Column]
    private array $costs_json = [];

    #[ORM\Column]
    private ?bool $gst_exempt = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $xero_purchase_order = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?DateTimeImmutable $back_order = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuoteId(): ?Quotes
    {
        return $this->quote_id;
    }

    public function setQuoteId(?Quotes $quote_id): static
    {
        $this->quote_id = $quote_id;

        return $this;
    }

    public function getPartId(): ?PartDatabase
    {
        return $this->part_id;
    }

    public function setPartId(?PartDatabase $part_id): static
    {
        $this->part_id = $part_id;

        return $this;
    }

    public function getLineItemIndex(): ?int
    {
        return $this->line_item_index;
    }

    public function setLineItemIndex(int $line_item_index): static
    {
        $this->line_item_index = $line_item_index;

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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): static
    {
        $this->details = $details;

        return $this;
    }

    public function getHeroImageUrl(): ?string
    {
        return $this->hero_image_url;
    }

    public function setHeroImageUrl(string $hero_image_url): static
    {
        $this->hero_image_url = $hero_image_url;

        return $this;
    }

    public function getCostsJson(): array
    {
        return $this->costs_json;
    }

    public function setCostsJson(array $costs_json): static
    {
        $this->costs_json = $costs_json;

        return $this;
    }

    public function isGstExempt(): ?bool
    {
        return $this->gst_exempt;
    }

    public function setGstExempt(bool $gst_exempt): static
    {
        $this->gst_exempt = $gst_exempt;

        return $this;
    }

    public function getXeroPurchaseOrder(): ?string
    {
        return $this->xero_purchase_order;
    }

    public function setXeroPurchaseOrder(string $xero_purchase_order): static
    {
        $this->xero_purchase_order = $xero_purchase_order;

        return $this;
    }

    public function getBackOrder(): ?DateTimeImmutable
    {
        return $this->back_order;
    }

    public function setBackOrder(?DateTimeImmutable $back_order): static
    {
        $this->back_order = $back_order;

        return $this;
    }
}
