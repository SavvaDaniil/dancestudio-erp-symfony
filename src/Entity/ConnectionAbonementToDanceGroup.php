<?php

namespace App\Entity;

use App\Repository\ConnectionAbonementToDanceGroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectionAbonementToDanceGroupRepository::class)]
class ConnectionAbonementToDanceGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'connection_abonement_to_dance_groups')]
    private ?Abonement $abonement = null;

    #[ORM\ManyToOne(inversedBy: 'connection_abonement_to_dance_groups')]
    private ?DanceGroup $dance_group = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDanceGroup(): ?DanceGroup
    {
        return $this->dance_group;
    }

    public function setDanceGroup(?DanceGroup $dance_group): self
    {
        $this->dance_group = $dance_group;

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
}
