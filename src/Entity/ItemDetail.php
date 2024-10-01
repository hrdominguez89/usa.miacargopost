<?php

namespace App\Entity;

use App\Repository\ItemDetailRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ItemDetailRepository::class)]
class ItemDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $detailedContents = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?float $netWeight = null;

    #[ORM\Column]
    private ?float $value = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $hsTarifNumber = null;

    #[ORM\ManyToOne(inversedBy: 'itemDetails')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Country $countryOfOriginOfGoods = null;

    #[ORM\ManyToOne(inversedBy: 'itemDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?S10Code $s10code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetailedContents(): ?string
    {
        return $this->detailedContents;
    }

    public function setDetailedContents(string $detailedContents): static
    {
        $this->detailedContents = $detailedContents;

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

    public function getNetWeight(): ?float
    {
        return $this->netWeight;
    }

    public function setNetWeight(float $netWeight): static
    {
        $this->netWeight = $netWeight;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getHsTarifNumber(): ?string
    {
        return $this->hsTarifNumber;
    }

    public function setHsTarifNumber(?string $hsTarifNumber): static
    {
        $this->hsTarifNumber = $hsTarifNumber;

        return $this;
    }

    public function getCountryOfOriginOfGoods(): ?Country
    {
        return $this->countryOfOriginOfGoods;
    }

    public function setCountryOfOriginOfGoods(?Country $countryOfOriginOfGoods): static
    {
        $this->countryOfOriginOfGoods = $countryOfOriginOfGoods;

        return $this;
    }

    public function getS10code(): ?S10Code
    {
        return $this->s10code;
    }

    public function setS10code(?S10Code $s10code): static
    {
        $this->s10code = $s10code;

        return $this;
    }
}
