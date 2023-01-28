<?php

namespace App\Entity;

use App\Repository\PurchaseAbonementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseAbonementRepository::class)]
class PurchaseAbonement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'purchase_abonements')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'purchase_abonements')]
    private ?Abonement $abonement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_buy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $days = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $visits_start = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $visits_left = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $price = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $cashless = null;

    ...


    public function __construct()
    {
        $this->visits_of_any_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAbonement(): ?Abonement
    {
        return $this->abonement;
    }

    public function setAbonement(?Abonement $abonement): self
    {
        $this->abonement = $abonement;

        return $this;
    }

    public function getDateOfBuy(): ?\DateTimeInterface
    {
        return $this->date_of_buy;
    }

    public function setDateOfBuy(?\DateTimeInterface $date_of_buy): self
    {
        $this->date_of_buy = $date_of_buy;

        return $this;
    }

    public function getDateOfAdd(): ?\DateTimeInterface
    {
        return $this->date_of_add;
    }

    public function setDateOfAdd(?\DateTimeInterface $date_of_add): self
    {
        $this->date_of_add = $date_of_add;

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

    public function getVisitsStart(): ?int
    {
        return $this->visits_start;
    }

    public function setVisitsStart(int $visits_start): self
    {
        $this->visits_start = $visits_start;

        return $this;
    }

    public function getVisitsLeft(): ?int
    {
        return $this->visits_left;
    }

    public function setVisitsLeft(int $visits_left): self
    {
        $this->visits_left = $visits_left;

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

    public function getCashless(): ?int
    {
        return $this->cashless;
    }

    public function setCashless(int $cashless): self
    {
        $this->cashless = $cashless;

        return $this;
    }

    ...
}
