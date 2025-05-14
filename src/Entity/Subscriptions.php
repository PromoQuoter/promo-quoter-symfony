<?php

namespace App\Entity;

use App\Repository\SubscriptionsRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: SubscriptionsRepository::class)]
class Subscriptions
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'user_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column(name: 'company_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company_id = null;

    #[ORM\Column(length: 255)]
    private ?string $stripe_id = null;

    #[ORM\Column(length: 255)]
    private ?string $stripe_price_id = null;

    #[ORM\Column(length: 255)]
    private ?string $stripe_subscription_item_id = null;

    #[ORM\Column(length: 255)]
    private ?string $stripe_status = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?DateTimeImmutable $ends_at = null;

    /**
     * @var Collection<int, Invoices>
     */
    #[ORM\OneToMany(targetEntity: Invoices::class, mappedBy: 'subscription_id')]
    private Collection $invoices;

    public function __construct()
    {
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): static
    {
        $this->user_id = $user_id;

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

    public function getStripeId(): ?string
    {
        return $this->stripe_id;
    }

    public function setStripeId(string $stripe_id): static
    {
        $this->stripe_id = $stripe_id;

        return $this;
    }

    public function getStripePriceId(): ?string
    {
        return $this->stripe_price_id;
    }

    public function setStripePriceId(string $stripe_price_id): static
    {
        $this->stripe_price_id = $stripe_price_id;

        return $this;
    }

    public function getStripeSubscriptionItemId(): ?string
    {
        return $this->stripe_subscription_item_id;
    }

    public function setStripeSubscriptionItemId(string $stripe_subscription_item_id): static
    {
        $this->stripe_subscription_item_id = $stripe_subscription_item_id;

        return $this;
    }

    public function getStripeStatus(): ?string
    {
        return $this->stripe_status;
    }

    public function setStripeStatus(string $stripe_status): static
    {
        $this->stripe_status = $stripe_status;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getEndsAt(): ?DateTimeImmutable
    {
        return $this->ends_at;
    }

    public function setEndsAt(DateTimeImmutable $ends_at): static
    {
        $this->ends_at = $ends_at;

        return $this;
    }

    /**
     * @return Collection<int, Invoices>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoices $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setSubscriptionId($this);
        }

        return $this;
    }

    public function removeInvoice(Invoices $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getSubscriptionId() === $this) {
                $invoice->setSubscriptionId(null);
            }
        }

        return $this;
    }
}
