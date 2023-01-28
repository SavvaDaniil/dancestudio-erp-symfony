<?php

namespace App\Entity;

use App\Repository\DanceGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DanceGroupRepository::class)]
class DanceGroup
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status_of_creative = null;

    ...

    public function __construct()
    {
        $this->dance_group_day_of_weeks = new ArrayCollection();
        $this->teacher_replacements = new ArrayCollection();
        $this->dance_group_cansels = new ArrayCollection();
        $this->connection_abonement_to_dance_groups = new ArrayCollection();
        $this->connection_dance_group_to_user_admins = new ArrayCollection();
        $this->connection_user_to_dance_groups = new ArrayCollection();
        $this->visits = new ArrayCollection();
        $this->teacher_salaries = new ArrayCollection();
    }

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatusOfCreative(): ?int
    {
        return $this->status_of_creative;
    }

    public function setStatusOfCreative(int $status_of_creative): self
    {
        $this->status_of_creative = $status_of_creative;

        return $this;
    }

    ...

    public function addConnectionAbonementToDanceGroup(ConnectionAbonementToDanceGroup $connectionAbonementToDanceGroup): self
    {
        if (!$this->connection_abonement_to_dance_groups->contains($connectionAbonementToDanceGroup)) {
            $this->connection_abonement_to_dance_groups->add($connectionAbonementToDanceGroup);
            $connectionAbonementToDanceGroup->setDanceGroup($this);
        }

        return $this;
    }

    public function removeConnectionAbonementToDanceGroup(ConnectionAbonementToDanceGroup $connectionAbonementToDanceGroup): self
    {
        if ($this->connection_abonement_to_dance_groups->removeElement($connectionAbonementToDanceGroup)) {
            // set the owning side to null (unless already changed)
            if ($connectionAbonementToDanceGroup->getDanceGroup() === $this) {
                $connectionAbonementToDanceGroup->setDanceGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConnectionDanceGroupToUserAdmin>
     */
    public function getConnectionDanceGroupToUserAdmins(): Collection
    {
        return $this->connection_dance_group_to_user_admins;
    }

    public function addConnectionDanceGroupToUserAdmin(ConnectionDanceGroupToUserAdmin $connectionDanceGroupToUserAdmin): self
    {
        if (!$this->connection_dance_group_to_user_admins->contains($connectionDanceGroupToUserAdmin)) {
            $this->connection_dance_group_to_user_admins->add($connectionDanceGroupToUserAdmin);
            $connectionDanceGroupToUserAdmin->setDanceGroup($this);
        }

        return $this;
    }

    public function removeConnectionDanceGroupToUserAdmin(ConnectionDanceGroupToUserAdmin $connectionDanceGroupToUserAdmin): self
    {
        if ($this->connection_dance_group_to_user_admins->removeElement($connectionDanceGroupToUserAdmin)) {
            // set the owning side to null (unless already changed)
            if ($connectionDanceGroupToUserAdmin->getDanceGroup() === $this) {
                $connectionDanceGroupToUserAdmin->setDanceGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ConnectionUserToDanceGroup>
     */
    public function getConnectionUserToDanceGroups(): Collection
    {
        return $this->connection_user_to_dance_groups;
    }

    public function addConnectionUserToDanceGroup(ConnectionUserToDanceGroup $connectionUserToDanceGroup): self
    {
        if (!$this->connection_user_to_dance_groups->contains($connectionUserToDanceGroup)) {
            $this->connection_user_to_dance_groups->add($connectionUserToDanceGroup);
            $connectionUserToDanceGroup->setDanceGroup($this);
        }

        return $this;
    }

    public function removeConnectionUserToDanceGroup(ConnectionUserToDanceGroup $connectionUserToDanceGroup): self
    {
        if ($this->connection_user_to_dance_groups->removeElement($connectionUserToDanceGroup)) {
            // set the owning side to null (unless already changed)
            if ($connectionUserToDanceGroup->getDanceGroup() === $this) {
                $connectionUserToDanceGroup->setDanceGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Visit>
     */
    public function getVisits(): Collection
    {
        return $this->visits;
    }

    public function addVisit(Visit $visit): self
    {
        if (!$this->visits->contains($visit)) {
            $this->visits->add($visit);
            $visit->setDanceGroup($this);
        }

        return $this;
    }

    public function removeVisit(Visit $visit): self
    {
        if ($this->visits->removeElement($visit)) {
            // set the owning side to null (unless already changed)
            if ($visit->getDanceGroup() === $this) {
                $visit->setDanceGroup(null);
            }
        }

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
            $teacherSalary->setDanceGroup($this);
        }

        return $this;
    }

    public function removeTeacherSalary(TeacherSalary $teacherSalary): self
    {
        if ($this->teacher_salaries->removeElement($teacherSalary)) {
            // set the owning side to null (unless already changed)
            if ($teacherSalary->getDanceGroup() === $this) {
                $teacherSalary->setDanceGroup(null);
            }
        }

        return $this;
    }
}
