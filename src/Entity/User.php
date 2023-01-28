<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $auth_key = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $access_token = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(type: Types::SMALLINT, options: ["default" => 0])]
    private ?int $active = null;

    //#[ORM\Column(length: 255, nullable: true)]
    //private ?string $fio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $secondname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    ...

    #[ORM\OneToMany(mappedBy: 'user_as_admin', targetEntity: ConnectionDanceGroupToUserAdmin::class)]
    private Collection $connection_dance_group_to_user_admins;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ConnectionDiscountToUser::class)]
    private Collection $connection_discount_to_users;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: ConnectionUserToDanceGroup::class)]
    private Collection $connection_user_to_dance_groups;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PurchaseAbonement::class)]
    private Collection $purchase_abonements;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Visit::class)]
    private Collection $visits;

    public function __construct()
    {
        ...
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    public function setAuthKey(?string $auth_key): self
    {
        $this->auth_key = $auth_key;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    public function setAccessToken(?string $access_token): self
    {
        $this->access_token = $access_token;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getSecondname(): ?string
    {
        return $this->secondname;
    }

    public function setSecondname(?string $secondname): self
    {
        $this->secondname = $secondname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    ...

}
