<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert; // Symfony's built-in constraints

#[ApiResource(
    operations: [
        new GetCollection(),
        new Post(processor: UserPasswordHasher::class),
        new Get(),
        new Put(processor: UserPasswordHasher::class),
        new Patch(processor: UserPasswordHasher::class),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:create', 'user:update']],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity('email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Groups(['user:read'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[Assert\NotBlank(groups: ['user:create'])]
    #[Groups(['user:create', 'user:update'])]
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[Assert\NotBlank(groups: ['user:create'])]
    #[Groups(['user:create', 'user:update'])]
    private ?string $plainPassword = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private string $password = '';

    #[Assert\NotBlank(groups: ['user:create', 'user:update'])]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 50)]
    private ?string $first_name = null;
    #[Assert\NotBlank(groups: ['user:create', 'user:update'])]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(length: 50)]
    private ?string $last_name = null;

    #[Groups(['user:read', 'user:update'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $verified_at = null;

    #[Assert\Json]
    #[Groups(['user:read', 'user:create', 'user:update'])]
    #[ORM\Column(type: 'json')]
    private array $coordinates;

    #[Groups(['user:read'])]
    #[ORM\Column]
    private \DateTimeImmutable $created_at;

    #[Groups(['user:read'])]
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\OneToMany(mappedBy: 'orderer', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'recover', targetEntity: Recovery::class)]
    private Collection $recoveries;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->recoveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $painPassword): self
    {
        $this->plainPassword = $painPassword;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getVerifiedAt(): ?\DateTimeImmutable
    {
        return $this->verified_at;
    }

    public function setVerifiedAt(?\DateTimeImmutable $verified_at): self
    {
        $this->verified_at = $verified_at;

        return $this;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function setCoordinates(array $coordinates): self
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    public function getCreatedAt(): DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setOrderer($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getOrderer() === $this) {
                $order->setOrderer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Recovery>
     */
    public function getRecoveries(): Collection
    {
        return $this->recoveries;
    }

    public function addRecovery(Recovery $recovery): self
    {
        if (!$this->recoveries->contains($recovery)) {
            $this->recoveries->add($recovery);
            $recovery->setRecover($this);
        }

        return $this;
    }

    public function removeRecovery(Recovery $recovery): self
    {
        if ($this->recoveries->removeElement($recovery)) {
            // set the owning side to null (unless already changed)
            if ($recovery->getRecover() === $this) {
                $recovery->setRecover(null);
            }
        }

        return $this;
    }
}
