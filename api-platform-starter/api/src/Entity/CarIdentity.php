<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CarIdentityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CarIdentityRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:get:carIdentity', 'id']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['item:post:carIdentity']],
        ),
        new Get(
            normalizationContext: ['groups' => ['item:get:carIdentity', 'id']],
        ),
        new Put(
            denormalizationContext: ['groups' => ['item:put:carIdentity']],
        ),
        new Patch(
            denormalizationContext: ['groups' => ['item:patch:carIdentity']],
        ),
        new Delete(),
        new GetCollection(
            uriTemplate: '/car_categories/{id}/car_identities',
            uriVariables: [
                'id' => new Link(
                    fromProperty: 'carIdentities',
                    fromClass: CarCategory::class
                )
            ],
            normalizationContext: ['groups' => ['collection:get:carIdentity', 'id']],
        ),
    ],
    normalizationContext: ['groups' => ['collection:get:carIdentity', 'item:get:carIdentity']],
    denormalizationContext: ['groups' => ['item:post:carIdentity', 'item:put:carIdentity', 'item:patch:carIdentity']],
    paginationClientEnabled: true,
    paginationClientItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
)]
class CarIdentity
{
    #[Groups(['collection:get:carIdentity', 'item:get:carIdentity', 'id'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['collection:get:carIdentity', 'item:get:carIdentity', 'item:post:carIdentity', 'item:put:carIdentity', 'item:patch:carIdentity'])]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Groups(['collection:get:carIdentity', 'item:get:carIdentity', 'item:post:carIdentity', 'item:put:carIdentity', 'item:patch:carIdentity'])]
    #[ORM\ManyToOne(inversedBy: 'carIdentities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarCategory $category = null;

    #[ORM\OneToMany(mappedBy: 'identity', targetEntity: Car::class, orphanRemoval: true)]
    private Collection $cars;

    #[Groups(['collection:get:carIdentity', 'item:get:carIdentity'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Image $mainPicture = null;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
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

    public function getCategory(): ?CarCategory
    {
        return $this->category;
    }

    public function setCategory(?CarCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, Car>
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Car $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars->add($car);
            $car->setIdentity($this);
        }

        return $this;
    }

    public function removeCar(Car $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getIdentity() === $this) {
                $car->setIdentity(null);
            }
        }

        return $this;
    }

    public function getMainPicture(): ?Image
    {
        return $this->mainPicture;
    }

    public function setMainPicture(?Image $mainPicture): self
    {
        $this->mainPicture = $mainPicture;

        return $this;
    }
}
