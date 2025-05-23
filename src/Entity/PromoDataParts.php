<?php

namespace App\Entity;

use App\Repository\PromoDataPartsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoDataPartsRepository::class)]
class PromoDataParts
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private array $data = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
