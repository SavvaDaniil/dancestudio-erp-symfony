<?php

namespace App\ViewModel\User;

class UserProfileViewModel {

    public int $id;
    public ?string $username;
    public ?string $secondname;
    public ?string $firstname;
    public ?string $patronymic;
    public ?string $telephone;
    public int $gender;
    public ?string $birthday;
    public ?string $parent_fio;
    public ?string $parent_phone;
    public ?string $comment;

    public function __construct(
        int $id,
        ?string $username,
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
        $this->id = $id;
        $this->username = $username;
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
}