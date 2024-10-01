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

    #[ORM\OneToMany(mappedBy: 'categoryItem', targetEntity: CategoryItemS10code::class)]
    private Collection $categoryItemS10codes;

    public function __construct()
    {
        $this->categoryItemS10codes = new ArrayCollection();
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
     * @return Collection<int, CategoryItemS10code>
     */
    public function getCategoryItemS10codes(): Collection
    {
        return $this->categoryItemS10codes;
    }

    public function addCategoryItemS10code(CategoryItemS10code $categoryItemS10code): static
    {
        if (!$this->categoryItemS10codes->contains($categoryItemS10code)) {
            $this->categoryItemS10codes->add($categoryItemS10code);
            $categoryItemS10code->setCategoryItem($this);
        }

        return $this;
    }

    public function removeCategoryItemS10code(CategoryItemS10code $categoryItemS10code): static
    {
        if ($this->categoryItemS10codes->removeElement($categoryItemS10code)) {
            // set the owning side to null (unless already changed)
            if ($categoryItemS10code->getCategoryItem() === $this) {
                $categoryItemS10code->setCategoryItem(null);
            }
        }

        return $this;
    }

}
