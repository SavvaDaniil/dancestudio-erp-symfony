<?php

namespace App\ViewModel\User;

class UserMicroViewModel {

    public int $id;
    public ?string $username;
    public ?string $secondname;
    public ?string $firstname;

    public function __construct(
        int $id,
        ?string $username,
        ?string $secondname,
        ?string $firstname
    )
    {
        $this->id = $id;
        $this->username = $username;
        $this->secondname = $secondname;
        $this->firstname = $firstname;
    }

}