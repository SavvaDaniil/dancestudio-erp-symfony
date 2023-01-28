<?php

namespace App\Entity;

use App\Repository\ConnectionUserToDanceGroupRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectionUserToDanceGroupRepository::class)]
class ConnectionUserToDanceGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'connection_user_to_dance_groups')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'connection_user_to_dance_groups')]
    private ?DanceGroup $dance_group = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_update = null;

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

    public function getDateOfUpdate(): ?\DateTimeInterface
    {
        return $this->date_of_update;
    }

    public function setDateOfUpdate(?\DateTimeInterface $date_of_update): self
    {
        $this->date_of_update = $date_of_update;

        return $this;
    }
}
