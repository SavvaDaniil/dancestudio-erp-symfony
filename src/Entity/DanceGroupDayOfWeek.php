<?php

namespace App\Entity;

use App\Repository\DanceGroupDayOfWeekRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DanceGroupDayOfWeekRepository::class)]
class DanceGroupDayOfWeek
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $day_of_week = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_from = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $time_to = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $is_event = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_event = null;

    ...

    public function __construct()
    {
        $this->teacher_replacements = new ArrayCollection();
        $this->visits = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayOfWeek(): ?int
    {
        return $this->day_of_week;
    }

    public function setDayOfWeek(int $day_of_week): self
    {
        $this->day_of_week = $day_of_week;

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

    public function getTimeFrom(): ?\DateTimeInterface
    {
        return $this->time_from;
    }

    public function setTimeFrom(?\DateTimeInterface $time_from): self
    {
        $this->time_from = $time_from;

        return $this;
    }

    public function getTimeTo(): ?\DateTimeInterface
    {
        return $this->time_to;
    }

    public function setTimeTo(?\DateTimeInterface $time_to): self
    {
        $this->time_to = $time_to;

        return $this;
    }

    public function getIsEvent(): ?int
    {
        return $this->is_event;
    }

    public function setIsEvent(int $is_event): self
    {
        $this->is_event = $is_event;

        return $this;
    }

    public function getDateOfEvent(): ?\DateTimeInterface
    {
        return $this->date_of_event;
    }

    public function setDateOfEvent(?\DateTimeInterface $date_of_event): self
    {
        $this->date_of_event = $date_of_event;

        return $this;
    }

    ...
}
