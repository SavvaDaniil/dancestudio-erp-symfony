<?php

namespace App\Entity;

use App\Repository\AdminRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AdminRepository::class)]
#[ORM\Table(name: '`admin`')]
class Admin implements UserInterface, PasswordAuthenticatedUserInterface
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

    #[ORM\Column(type: Types::SMALLINT, options: ["default" => 0])]
    private ?int $level = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_add = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_of_last_update_profile = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["default" => 0])]
    private ?int $panel_admins = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["default" => 0])]
    private ?int $panel_lessons = null;

    ...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
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

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

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

    public function getDateOfAdd(): ?\DateTimeInterface
    {
        return $this->date_of_add;
    }

    public function setDateOfAdd(?\DateTimeInterface $date_of_add): self
    {
        $this->date_of_add = $date_of_add;

        return $this;
    }

    public function getDateOfLastUpdateProfile(): ?\DateTimeInterface
    {
        return $this->date_of_last_update_profile;
    }

    public function setDateOfLastUpdateProfile(?\DateTimeInterface $date_of_last_update_profile): self
    {
        $this->date_of_last_update_profile = $date_of_last_update_profile;

        return $this;
    }

    public function getPanelAdmins(): ?int
    {
        return $this->panel_admins;
    }

    public function setPanelAdmins(int $panel_admins): self
    {
        $this->panel_admins = $panel_admins;

        return $this;
    }

    public function getPanelLessons(): ?int
    {
        return $this->panel_lessons;
    }

    public function setPanelLessons(int $panel_lessons): self
    {
        $this->panel_lessons = $panel_lessons;

        return $this;
    }

    ...
}
