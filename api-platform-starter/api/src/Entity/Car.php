<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ApiResource]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 20)]
    private ?string $fuel = null;

    #[ORM\Column(nullable: true)]
    private ?int $power = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column]
    private ?float $speeding = null;

    #[ORM\Column(nullable: true)]
    private ?float $consumption = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'car', targetEntity: Recovery::class)]
    private Collection $recoveries;

    #[ORM\Column]
    private ?int $year = null;

    #[ORM\Column(type: 'json')]
    private array $options = [];

    #[ORM\ManyToMany(targetEntity: Image::class)]
    private Collection $images;

    #[ORM\Column(length: 10)]
    private ?string $gearbox_type = null;

    #[ORM\Column]
    private ?int $mileage = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CarIdentity $identity = null;

    #[ORM\ManyToOne(inversedBy: 'cars')]
    private ?Garage $garage = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->recoveries = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getPower(): ?int
    {
        return $this->power;
    }

    public function setPower(?int $power): self
    {
        $this->power = $power;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getSpeeding(): ?float
    {
        return $this->speeding;
    }

    public function setSpeeding(float $speeding): self
    {
        $this->speeding = $speeding;

        return $this;
    }

    public function getConsumption(): ?float
    {
        return $this->consumption;
    }

    public function setConsumption(?float $consumption): self
    {
        $this->consumption = $consumption;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
            $order->setCar($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        // set the owning side to null (unless already changed)
        if ($this->orders->removeElement($order) && $order->getCar() === $this) {
            $order->setCar(null);
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
            $recovery->setCar($this);
        }

        return $this;
    }

    public function removeRecovery(Recovery $recovery): self
    {
        // set the owning side to null (unless already changed)
        if ($this->recoveries->removeElement($recovery) && $recovery->getCar() === $this) {
            $recovery->setCar(null);
        }

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function setOptions(?array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $this->images->removeElement($image);

        return $this;
    }

    public function getGearboxType(): ?string
    {
        return $this->gearbox_type;
    }

    public function setGearboxType(string $gearbox_type): self
    {
        $this->gearbox_type = $gearbox_type;

        return $this;
    }

    public function getMileage(): ?int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;

        return $this;
    }

    public function getIdentity(): ?CarIdentity
    {
        return $this->identity;
    }

    public function setIdentity(?CarIdentity $identity): self
    {
        $this->identity = $identity;

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
}
