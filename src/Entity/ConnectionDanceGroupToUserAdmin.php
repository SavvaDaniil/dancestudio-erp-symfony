<?php

namespace App\Entity;

use App\Repository\ConnectionDanceGroupToUserAdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectionDanceGroupToUserAdminRepository::class)]
class ConnectionDanceGroupToUserAdmin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'connection_dance_group_to_user_admins')]
    private ?DanceGroup $dance_group = null;

    ...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDanceGroup(): ?DanceGroup
    {
        return $this->dance_group;
    }

    ...
}
