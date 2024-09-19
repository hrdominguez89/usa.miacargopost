<?php

namespace App\Entity;

use App\Repository\CategoryItemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryItemRepository::class)]
class CategoryItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'categoryItem', targetEntity: S10Code::class)]
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
            $s10Code->setCategoryItem($this);
        }

        return $this;
    }

    public function removeS10Code(S10Code $s10Code): static
    {
        if ($this->s10Codes->removeElement($s10Code)) {
            // set the owning side to null (unless already changed)
            if ($s10Code->getCategoryItem() === $this) {
                $s10Code->setCategoryItem(null);
            }
        }

        return $this;
    }
}
