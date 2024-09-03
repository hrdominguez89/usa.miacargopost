<?php

namespace App\Entity;

use App\Repository\PostalProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostalProductRepository::class)]
class PostalProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'postalProduct', targetEntity: PostalService::class)]
    private Collection $postalServices;

    public function __construct()
    {
        $this->postalServices = new ArrayCollection();
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
     * @return Collection<int, PostalService>
     */
    public function getPostalServices(): Collection
    {
        return $this->postalServices;
    }

    public function addPostalService(PostalService $postalService): static
    {
        if (!$this->postalServices->contains($postalService)) {
            $this->postalServices->add($postalService);
            $postalService->setPostalProduct($this);
        }

        return $this;
    }

    public function removePostalService(PostalService $postalService): static
    {
        if ($this->postalServices->removeElement($postalService)) {
            // set the owning side to null (unless already changed)
            if ($postalService->getPostalProduct() === $this) {
                $postalService->setPostalProduct(null);
            }
        }

        return $this;
    }
}
