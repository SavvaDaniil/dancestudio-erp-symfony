<?php

namespace App\Entity;

use App\Repository\TeacherReplacementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherReplacementRepository::class)]
class TeacherReplacement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_day = null;

    #[ORM\ManyToOne(inversedBy: 'teacher_replacements')]
    private ?DanceGroup $dance_group = null;

    #[ORM\ManyToOne(inversedBy: 'teacher_replacements')]
    private ?DanceGroupDayOfWeek $dance_group_day_of_week = null;

    #[ORM\ManyToOne(inversedBy: 'teacher_replacements')]
    private ?Teacher $teacher_replace = null;

    #[ORM\OneToMany(mappedBy: 'teacher_replacement', targetEntity: TeacherSalary::class)]
    private Collection $teacher_salaries;

    public function __construct()
    {
        $this->teacher_salaries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfDay(): ?\DateTimeInterface
    {
        return $this->date_of_day;
    }

    public function setDateOfDay(?\DateTimeInterface $date_of_day): self
    {
        $this->date_of_day = $date_of_day;

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

    public function getTeacherReplace(): ?Teacher
    {
        return $this->teacher_replace;
    }

    public function setTeacherReplace(?Teacher $teacher_replace): self
    {
        $this->teacher_replace = $teacher_replace;

        return $this;
    }

    /**
     * @return Collection<int, TeacherSalary>
     */
    public function getTeacherSalaries(): Collection
    {
        return $this->teacher_salaries;
    }

    public function addTeacherSalary(TeacherSalary $teacherSalary): self
    {
        if (!$this->teacher_salaries->contains($teacherSalary)) {
            $this->teacher_salaries->add($teacherSalary);
            $teacherSalary->setTeacherReplacement($this);
        }

        return $this;
    }

    public function removeTeacherSalary(TeacherSalary $teacherSalary): self
    {
        if ($this->teacher_salaries->removeElement($teacherSalary)) {
            // set the owning side to null (unless already changed)
            if ($teacherSalary->getTeacherReplacement() === $this) {
                $teacherSalary->setTeacherReplacement(null);
            }
        }

        return $this;
    }
}
