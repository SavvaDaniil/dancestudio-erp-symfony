<?php

namespace App\Entity;

use App\Repository\AbonementDynamicDateMustBeUsedToRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonementDynamicDateMustBeUsedToRepository::class)]
class AbonementDynamicDateMustBeUsedTo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'abonement_dynamic_date_must_be_used_tos')]
    private ?Abonement $abonement = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    
    ...

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_used_to = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_update = null;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    ..

    public function getDateUsedTo(): ?\DateTimeInterface
    {
        return $this->date_used_to;
    }

    public function setDateUsedTo(?\DateTimeInterface $date_used_to): self
    {
        $this->date_used_to = $date_used_to;

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
