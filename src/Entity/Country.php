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

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: S10Code::class)]
    private Collection $s10Codes;

    public function __construct()
    {
        $this->s10Codes = new ArrayCollection();
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
    public function getS10Codes(): Collection
    {
        return $this->s10Codes;
    }

    public function addS10Code(S10Code $s10Code): static
    {
        if (!$this->s10Codes->contains($s10Code)) {
            $this->s10Codes->add($s10Code);
            $s10Code->setCountry($this);
        }

        return $this;
    }

    public function removeS10Code(S10Code $s10Code): static
    {
        if ($this->s10Codes->removeElement($s10Code)) {
            // set the owning side to null (unless already changed)
            if ($s10Code->getCountry() === $this) {
                $s10Code->setCountry(null);
            }
        }

        return $this;
    }
}
