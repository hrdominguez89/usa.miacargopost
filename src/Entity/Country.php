<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[UniqueEntity('iso2')]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 2,unique: true)]
    private ?string $iso2 = null;

    #[ORM\Column(length: 50)]
    private ?string $currencyName = null;

    #[ORM\Column(length: 5)]
    private ?string $currencySign = null;

    #[ORM\OneToMany(mappedBy: 'fromCountry', targetEntity: S10Code::class)]
    private Collection $s10CodesFrom;

    #[ORM\OneToMany(mappedBy: 'toCountry', targetEntity: S10Code::class)]
    private Collection $s10codesTo;

    #[ORM\OneToMany(mappedBy: 'countryOfOriginOfGoods', targetEntity: ItemDetail::class)]
    private Collection $itemDetails;

    public function __construct()
    {
        $this->s10CodesFrom = new ArrayCollection();
        $this->s10codesTo = new ArrayCollection();
        $this->itemDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getIso2(): ?string
    {
        return $this->iso2;
    }

    public function setIso2(string $iso2): static
    {
        $this->iso2 = $iso2;

        return $this;
    }

    public function getCurrencyName(): ?string
    {
        return $this->currencyName;
    }

    public function setCurrencyName(string $currencyName): static
    {
        $this->currencyName = $currencyName;

        return $this;
    }

    public function getCurrencySign(): ?string
    {
        return $this->currencySign;
    }

    public function setCurrencySign(string $currencySign): static
    {
        $this->currencySign = $currencySign;

        return $this;
    }

    /**
     * @return Collection<int, S10Code>
     */
    public function getS10CodesFrom(): Collection
    {
        return $this->s10CodesFrom;
    }

    public function addS10CodesFrom(S10Code $s10CodesFrom): static
    {
        if (!$this->s10CodesFrom->contains($s10CodesFrom)) {
            $this->s10CodesFrom->add($s10CodesFrom);
            $s10CodesFrom->setFromCountry($this);
        }

        return $this;
    }

    public function removeS10CodesFrom(S10Code $s10CodesFrom): static
    {
        if ($this->s10CodesFrom->removeElement($s10CodesFrom)) {
            // set the owning side to null (unless already changed)
            if ($s10CodesFrom->getFromCountry() === $this) {
                $s10CodesFrom->setFromCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, S10Code>
     */
    public function getS10codesTo(): Collection
    {
        return $this->s10codesTo;
    }

    public function addS10codesTo(S10Code $s10codesTo): static
    {
        if (!$this->s10codesTo->contains($s10codesTo)) {
            $this->s10codesTo->add($s10codesTo);
            $s10codesTo->setToCountry($this);
        }

        return $this;
    }

    public function removeS10codesTo(S10Code $s10codesTo): static
    {
        if ($this->s10codesTo->removeElement($s10codesTo)) {
            // set the owning side to null (unless already changed)
            if ($s10codesTo->getToCountry() === $this) {
                $s10codesTo->setToCountry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ItemDetail>
     */
    public function getItemDetails(): Collection
    {
        return $this->itemDetails;
    }

    public function addItemDetail(ItemDetail $itemDetail): static
    {
        if (!$this->itemDetails->contains($itemDetail)) {
            $this->itemDetails->add($itemDetail);
            $itemDetail->setCountryOfOriginOfGoods($this);
        }

        return $this;
    }

    public function removeItemDetail(ItemDetail $itemDetail): static
    {
        if ($this->itemDetails->removeElement($itemDetail)) {
            // set the owning side to null (unless already changed)
            if ($itemDetail->getCountryOfOriginOfGoods() === $this) {
                $itemDetail->setCountryOfOriginOfGoods(null);
            }
        }

        return $this;
    }
}
