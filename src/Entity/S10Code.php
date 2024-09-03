<?php

namespace App\Entity;

use App\Repository\S10CodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: S10CodeRepository::class)]
class S10Code
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 's10codes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PostalServiceRange $postalServiceRange = null;

    #[ORM\Column(length: 2)]
    private ?string $serviceCode = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $numbercode = null;

    #[ORM\ManyToOne(inversedBy: 's10Codes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Country $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostalServiceRange(): ?PostalServiceRange
    {
        return $this->postalServiceRange;
    }

    public function setPostalServiceRange(?PostalServiceRange $postalServiceRange): static
    {
        $this->postalServiceRange = $postalServiceRange;

        return $this;
    }

    public function getServiceCode(): ?string
    {
        return $this->serviceCode;
    }

    public function setServiceCode(string $serviceCode): static
    {
        $this->serviceCode = $serviceCode;

        return $this;
    }

    public function getNumbercode(): ?string
    {
        return $this->numbercode;
    }

    public function setNumbercode(string $numbercode): static
    {
        $this->numbercode = $numbercode;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getFormattedNumbercode(): string
    {
        return $this->serviceCode.str_pad($this->numbercode ?? '', 9, '0', STR_PAD_LEFT).$this->country->getIso2();
    }
}
