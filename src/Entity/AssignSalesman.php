<?php

namespace App\Entity;

use App\Repository\AssignSalesmanRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignSalesmanRepository::class)]
class AssignSalesman
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $customer_id = null;

    #[ORM\Column]
    private ?int $salesman_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getCustomerId(): ?int
    {
        return $this->customer_id;
    }

    public function setCustomerId(int $customer_id): static
    {
        $this->customer_id = $customer_id;

        return $this;
    }

    public function getSalesmanId(): ?int
    {
        return $this->salesman_id;
    }

    public function setSalesmanId(int $salesman_id): static
    {
        $this->salesman_id = $salesman_id;

        return $this;
    }
}
