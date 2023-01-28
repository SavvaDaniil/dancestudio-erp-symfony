<?php

namespace App\Entity;

use App\Repository\ConnectionAbonementPrivateToUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectionAbonementPrivateToUserRepository::class)]
class ConnectionAbonementPrivateToUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'connection_abonement_private_to_users')]
    private ?Abonement $abonement = null;

    #[ORM\ManyToOne(inversedBy: 'connection_abonement_private_to_users')]
    private ?User $user = null;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
