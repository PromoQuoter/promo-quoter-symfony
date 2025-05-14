<?php

namespace App\Entity;

use App\Repository\InvoicesRepository;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: InvoicesRepository::class)]
class Invoices
{
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'subscription_id', nullable: true)]
    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Subscriptions $subscription_id = null;

    #[ORM\Column(length: 255)]
    private ?string $stripe_id = null;

    #[ORM\Column(length: 255)]
    private ?string $stripe_status = null;

    #[ORM\Column]
    private ?int $amount_due = null;

    #[ORM\Column]
    private ?int $amount_paid = null;

    #[ORM\Column]
    private ?int $attempt_count = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $next_payment_attempt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriptionId(): ?Subscriptions
    {
        return $this->subscription_id;
    }

    public function setSubscriptionId(?Subscriptions $subscription_id): static
    {
        $this->subscription_id = $subscription_id;

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

    public function getStripeStatus(): ?string
    {
        return $this->stripe_status;
    }

    public function setStripeStatus(string $stripe_status): static
    {
        $this->stripe_status = $stripe_status;

        return $this;
    }

    public function getAmountDue(): ?int
    {
        return $this->amount_due;
    }

    public function setAmountDue(int $amount_due): static
    {
        $this->amount_due = $amount_due;

        return $this;
    }

    public function getAmountPaid(): ?int
    {
        return $this->amount_paid;
    }

    public function setAmountPaid(int $amount_paid): static
    {
        $this->amount_paid = $amount_paid;

        return $this;
    }

    public function getAttemptCount(): ?int
    {
        return $this->attempt_count;
    }

    public function setAttemptCount(int $attempt_count): static
    {
        $this->attempt_count = $attempt_count;

        return $this;
    }

    public function getNextPaymentAttempt(): ?DateTimeImmutable
    {
        return $this->next_payment_attempt;
    }

    public function setNextPaymentAttempt(?DateTimeImmutable $next_payment_attempt): static
    {
        $this->next_payment_attempt = $next_payment_attempt;

        return $this;
    }
}
