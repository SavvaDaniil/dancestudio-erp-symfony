<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_update = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["default" => 0])]
    private ?int $stavka = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["default" => 0])]
    private ?int $min_students = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["default" => 0])]
    private ?int $raz = null;

    ...

    #[ORM\OneToMany(mappedBy: 'teacher_replacement', targetEntity: TeacherSalary::class)]
    private Collection $teacher_replacement;

    #[ORM\OneToMany(mappedBy: 'teacher_replace', targetEntity: TeacherReplacement::class)]
    private Collection $teacher_replacements;

    ...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getStavka(): ?int
    {
        return $this->stavka;
    }

    public function setStavka(int $stavka): self
    {
        $this->stavka = $stavka;

        return $this;
    }

    public function getMinStudents(): ?int
    {
        return $this->min_students;
    }

    public function setMinStudents(int $min_students): self
    {
        $this->min_students = $min_students;

        return $this;
    }

    public function getRaz(): ?int
    {
        return $this->raz;
    }

    public function setRaz(int $raz): self
    {
        $this->raz = $raz;

        return $this;
    }

    ...
    
    /**
     * @return Collection<int, TeacherSalary>
     */
    public function getTeacherReplacement(): Collection
    {
        return $this->teacher_replacement;
    }

    public function addTeacherReplacement(TeacherSalary $teacherReplacement): self
    {
        if (!$this->teacher_replacement->contains($teacherReplacement)) {
            $this->teacher_replacement->add($teacherReplacement);
            $teacherReplacement->setTeacherReplacement($this);
        }

        return $this;
    }

    public function removeTeacherReplacement(TeacherSalary $teacherReplacement): self
    {
        if ($this->teacher_replacement->removeElement($teacherReplacement)) {
            // set the owning side to null (unless already changed)
            if ($teacherReplacement->getTeacherReplacement() === $this) {
                $teacherReplacement->setTeacherReplacement(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeacherReplacement>
     */
    public function getTeacherReplacements(): Collection
    {
        return $this->teacher_replacements;
    }
}
