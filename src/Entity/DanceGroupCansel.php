<?php

namespace App\Entity;

use App\Repository\DanceGroupCanselRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DanceGroupCanselRepository::class)]
class DanceGroupCansel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dance_group_cansels')]
    private ?DanceGroup $dance_group = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_from = null;

    ...

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDateFrom(): ?\DateTimeInterface
    {
        return $this->date_from;
    }

    public function setDateFrom(?\DateTimeInterface $date_from): self
    {
        $this->date_from = $date_from;

        return $this;
    }

    ...
}
