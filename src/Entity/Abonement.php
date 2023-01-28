<?php

namespace App\Entity;

use App\Repository\AbonementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonementRepository::class)]
class Abonement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $special_status = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $days = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $price = null;

    
    ...

    #[ORM\OneToMany(mappedBy: 'abonement', targetEntity: ConnectionAbonementToDiscount::class)]
    private Collection $connection_abonement_to_discounts;

    #[ORM\OneToMany(mappedBy: 'abonement', targetEntity: PurchaseAbonement::class)]
    private Collection $purchase_abonements;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_update = null;

    public function __construct()
    {
        ...
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

    public function getSpecialStatus(): ?string
    {
        return $this->special_status;
    }

    public function setSpecialStatus(?string $special_status): self
    {
        $this->special_status = $special_status;

        return $this;
    }

    public function getDays(): ?int
    {
        return $this->days;
    }

    public function setDays(int $days): self
    {
        $this->days = $days;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    ...

}
