<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CarCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarCategoryRepository::class)]
#[ApiResource]
class CarCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 80, unique: true)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: CarIdentity::class, orphanRemoval: true)]
    private Collection $carIdentities;

    public function __construct()
    {
        $this->carIdentities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, CarIdentity>
     */
    public function getCarIdentities(): Collection
    {
        return $this->carIdentities;
    }

    public function addCarIdentity(CarIdentity $carIdentity): self
    {
        if (!$this->carIdentities->contains($carIdentity)) {
            $this->carIdentities->add($carIdentity);
            $carIdentity->setCategory($this);
        }

        return $this;
    }

    public function removeCarIdentity(CarIdentity $carIdentity): self
    {
        // set the owning side to null (unless already changed)
        if ($this->carIdentities->removeElement($carIdentity) && $carIdentity->getCategory() === $this) {
            $carIdentity->setCategory(null);
        }

        return $this;
    }
}
