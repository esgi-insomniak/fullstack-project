<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\StatusRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StatusRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['collection:get:status', 'id']],
        ),
        new Post(
            denormalizationContext: ['groups' => ['item:post:status']],
        ),
        new Get(
            normalizationContext: ['groups' => ['item:get:status', 'id']],
        ),
        new Put(
            denormalizationContext: ['groups' => ['item:put:status']],
        ),
        new Patch(
            denormalizationContext: ['groups' => ['item:patch:status']],
        ),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['collection:get:status', 'item:get:status']],
    denormalizationContext: ['groups' => ['item:post:status', 'item:put:status', 'item:patch:status']],
    paginationClientEnabled: true,
    paginationClientItemsPerPage: 10,
    paginationMaximumItemsPerPage: 50,
)]
class Status
{
    #[Groups(['collection:get:status', 'item:get:status', 'id'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['collection:get:status', 'item:get:status', 'item:post:status', 'item:put:status', 'item:patch:status'])]
    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[Groups(['collection:get:status', 'item:get:status', 'item:post:status', 'item:put:status', 'item:patch:status', 'id'])]
    #[ORM\Column(length: 50)]
    private ?string $slug = null;

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
}
