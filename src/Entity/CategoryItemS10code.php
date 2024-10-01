<?php

namespace App\Entity;

use App\Repository\CategoryItemS10codeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryItemS10codeRepository::class)]
class CategoryItemS10code
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'categoryItemS10codes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?S10Code $s10code = null;

    #[ORM\ManyToOne(inversedBy: 'categoryItemS10codes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CategoryItem $categoryItem = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCategoryItem(): ?CategoryItem
    {
        return $this->categoryItem;
    }

    public function setCategoryItem(?CategoryItem $categoryItem): static
    {
        $this->categoryItem = $categoryItem;

        return $this;
    }
}
