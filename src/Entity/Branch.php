<?php

namespace App\Entity;

use App\Repository\BranchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BranchRepository::class)]
class Branch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    
    ...

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_update = null;

    #[ORM\OneToMany(mappedBy: 'branch', targetEntity: DanceGroup::class)]
    private Collection $dance_groups;

    public function __construct()
    {
        $this->dance_groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    ...

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

    /**
     * @return Collection<int, DanceGroup>
     */
    public function getDanceGroups(): Collection
    {
        return $this->dance_groups;
    }

    public function addDanceGroup(DanceGroup $danceGroup): self
    {
        if (!$this->dance_groups->contains($danceGroup)) {
            $this->dance_groups->add($danceGroup);
            $danceGroup->setBranch($this);
        }

        return $this;
    }

    public function removeDanceGroup(DanceGroup $danceGroup): self
    {
        if ($this->dance_groups->removeElement($danceGroup)) {
            // set the owning side to null (unless already changed)
            if ($danceGroup->getBranch() === $this) {
                $danceGroup->setBranch(null);
            }
        }

        return $this;
    }
}
