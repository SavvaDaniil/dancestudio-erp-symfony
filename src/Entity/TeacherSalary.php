<?php

namespace App\Entity;

use App\Repository\TeacherSalaryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherSalaryRepository::class)]
class TeacherSalary
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //#[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    //private ?\DateTimeInterface $date_of_day = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_action = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_update = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

 
    ...

    #[ORM\ManyToOne(inversedBy: 'teacher_salaries')]
    private ?Teacher $teacher = null;

    #[ORM\ManyToOne(inversedBy: 'teacher_salaries')]
    private ?TeacherReplacement $teacher_replacement = null;

    #[ORM\ManyToOne(inversedBy: 'teacher_salaries')]
    private ?DanceGroup $dance_group = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfAction(): ?\DateTimeInterface
    {
        return $this->date_of_action;
    }

    public function setDateOfAction(?\DateTimeInterface $date_of_action): self
    {
        $this->date_of_action = $date_of_action;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    ...

    
    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getTeacherReplacement(): ?TeacherReplacement
    {
        return $this->teacher_replacement;
    }

    public function setTeacherReplacement(?TeacherReplacement $teacher_replacement): self
    {
        $this->teacher_replacement = $teacher_replacement;

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
}
