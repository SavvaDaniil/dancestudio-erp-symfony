<?php

namespace App\DTO\User;

class UserEditDTO {
    
    private int $user_id;
    private ?string $username;
    private ?string $password;
    private ?string $secondname;
    private ?string $firstname;
    private ?string $patronymic;
    private ?string $telephone;
    private int $gender;
    private ?string $birthday;
    private ?string $parent_fio;
    private ?string $parent_phone;
    private ?string $comment;

    public function __construct(
        int $user_id,
        ?string $username,
        ?string $password,
        ?string $secondname,
        ?string $firstname,
        ?string $patronymic,
        ?string $telephone,
        int $gender,
        ?string $birthday,
        ?string $parent_fio,
        ?string $parent_phone,
        ?string $comment
    )
    {
        $this->user_id = $user_id;
        $this->username = $username;
        $this->password = $password;
        $this->secondname = $secondname;
        $this->firstname = $firstname;
        $this->patronymic = $patronymic;
        $this->telephone = $telephone;
        $this->gender = $gender;
        $this->birthday = $birthday;
        $this->parent_fio = $parent_fio;
        $this->parent_phone = $parent_phone;
        $this->comment = $comment;
    }
    

    /**
     * Get the value of user_id
     */ 
    public function getUser_id(): int
    {
        return $this->user_id;
    }

    /**
     * Get the value of username
     */ 
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Get the value of password
     */ 
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Get the value of secondname
     */ 
    public function getSecondname(): ?string
    {
        return $this->secondname;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * Get the value of patronymic
     */ 
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * Get the value of telephone
     */ 
    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    /**
     * Get the value of gender
     */ 
    public function getGender(): int
    {
        return $this->gender;
    }

    /**
     * Get the value of birthday
     */ 
    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    /**
     * Get the value of parent_fio
     */ 
    public function getParent_fio(): ?string
    {
        return $this->parent_fio;
    }

    /**
     * Get the value of parent_phone
     */ 
    public function getParent_phone(): ?string
    {
        return $this->parent_phone;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment(): ?string
    {
        return $this->comment;
    }
}