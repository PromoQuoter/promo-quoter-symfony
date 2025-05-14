<?php

namespace App\Entity;

use App\Repository\CustomerBusinessSourceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerBusinessSourceRepository::class)]
class CustomerBusinessSource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'customer_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'customerBusinessSources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Customer $customer_id = null;

    #[ORM\Column(name: 'resource_id', type: Types::INTEGER)]
    #[ORM\ManyToOne(inversedBy: 'customerBusinessSources')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BusinessSource $resource_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerId(): ?Customer
    {
        return $this->customer_id;
    }

    public function setCustomerId(?Customer $customer_id): static
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getResourceId(): ?BusinessSource
    {
        return $this->resource_id;
    }

    public function setResourceId(?BusinessSource $resource_id): static
    {
        $this->resource_id = $resource_id;

        return $this;
    }
}
