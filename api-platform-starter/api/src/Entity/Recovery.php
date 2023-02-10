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
use App\Repository\RecoveryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RecoveryRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:get:recovery', 'id']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['item:post:recovery']],
        ),
        new Get(
            normalizationContext: ['groups' => ['item:get:recovery', 'id']],
        ),
        new Put(
            denormalizationContext: ['groups' => ['item:put:recovery']],
        ),
        new Patch(
            denormalizationContext: ['groups' => ['item:patch:recovery']],
        ),
        new Delete(),
        new GetCollection(
            uriTemplate: '/users/{id}/recoveries',
            uriVariables: [
                'id' => new Link(
                    fromProperty: 'recoveries',
                    fromClass: User::class
                )
            ],
            normalizationContext: ['groups' => ['collection:get:recovery', 'id']],
        ),
        new GetCollection(
            uriTemplate: '/garages/{id}/recoveries',
            uriVariables: [
                'id' => new Link(
                    fromProperty: 'recoveries',
                    fromClass: Garage::class
                )
            ],
            normalizationContext: ['groups' => ['collection:get:recovery', 'id']],
        ),
        new GetCollection(
            uriTemplate: '/cars/{id}/recoveries',
            uriVariables: [
                'id' => new Link(
                    fromProperty: 'recoveries',
                    fromClass: Car::class
                )
            ],
            normalizationContext: ['groups' => ['collection:get:recovery', 'id']],
        ),
    ],
    normalizationContext: ['groups' => ['collection:get:recovery', 'item:get:recovery']],
    denormalizationContext: ['groups' => ['item:post:recovery', 'item:put:recovery', 'item:patch:recovery']],
    paginationClientEnabled: true,
    paginationClientItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
)]
class Recovery
{
    #[Groups(['collection:get:recovery', 'item:get:recovery', 'id'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery', 'item:post:recovery'])]
    #[ORM\ManyToOne(inversedBy: 'recoveries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Car $car = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery', 'item:post:recovery'])]
    #[ORM\ManyToOne(inversedBy: 'recoveries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $recover = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery', 'item:post:recovery'])]
    #[ORM\ManyToOne(inversedBy: 'recoveries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Garage $garage = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery', 'item:post:recovery', 'item:put:recovery', 'item:patch:recovery'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $carDescription = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery', 'item:post:recovery', 'item:put:recovery', 'item:patch:recovery'])]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Status $status = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery', 'item:post:recovery', 'item:put:recovery', 'item:patch:recovery'])]
    #[ORM\Column]
    private ?float $proposedPrice = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery', 'item:put:recovery', 'item:patch:recovery'])]
    #[ORM\Column]
    private ?float $totalPrice = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery'])]
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['collection:get:recovery', 'item:get:recovery'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCar(): ?Car
    {
        return $this->car;
    }

    public function setCar(?Car $car): self
    {
        $this->car = $car;

        return $this;
    }

    public function getRecover(): ?User
    {
        return $this->recover;
    }

    public function setRecover(?User $recover): self
    {
        $this->recover = $recover;

        return $this;
    }

    public function getGarage(): ?Garage
    {
        return $this->garage;
    }

    public function setGarage(?Garage $garage): self
    {
        $this->garage = $garage;

        return $this;
    }

    public function getCarDescription(): ?string
    {
        return $this->carDescription;
    }

    public function setCarDescription(?string $carDescription): self
    {
        $this->carDescription = $carDescription;

        return $this;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getProposedPrice(): ?float
    {
        return $this->proposedPrice;
    }

    public function setProposedPrice(float $proposedPrice): self
    {
        $this->proposedPrice = $proposedPrice;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
