<?php

namespace App\Entity;

use App\Repository\VisitRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitRepository::class)]
class Visit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_buy = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\ManyToOne(inversedBy: 'visits')]
    private ?User $user = null;

    
    ...

    #[ORM\ManyToOne(inversedBy: 'visits_of_any_user')]
    private ?PurchaseAbonement $purchase_abonement = null;

    #[ORM\Column(length: 32, nullable: true)]
    private ?string $special_status_of_abonement = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $is_add_by_app = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $is_reservation = null;

    ...

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDanceGroup(): ?DanceGroup
    {
        return $this->dance_group;
    }

    public function setDanceGroup(?DanceGroup $dance_group): self
    {
        $this->dance_group = $dance_group;

        return $this;
    }

    public function getDanceGroupDayOfWeek(): ?DanceGroupDayOfWeek
    {
        return $this->dance_group_day_of_week;
    }

    public function setDanceGroupDayOfWeek(?DanceGroupDayOfWeek $dance_group_day_of_week): self
    {
        $this->dance_group_day_of_week = $dance_group_day_of_week;

        return $this;
    }

    public function getPurchaseAbonement(): ?PurchaseAbonement
    {
        return $this->purchase_abonement;
    }

    public function setPurchaseAbonement(?PurchaseAbonement $purchase_abonement): self
    {
        $this->purchase_abonement = $purchase_abonement;

        return $this;
    }

    public function getSpecialStatusOfAbonement(): ?string
    {
        return $this->special_status_of_abonement;
    }

    public function setSpecialStatusOfAbonement(?string $special_status_of_abonement): self
    {
        $this->special_status_of_abonement = $special_status_of_abonement;

        return $this;
    }

    ...
}
