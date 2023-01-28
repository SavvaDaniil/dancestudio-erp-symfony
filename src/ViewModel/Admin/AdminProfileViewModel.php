<?php

namespace App\ViewModel\Admin;

class AdminProfileViewModel {

    public ?int $id = 0;
    public ?string $username;
    public ?string $firstname;

    public function __construct(?int $id, ?string $username, ?string $firstname){
        $this->id = $id;
        $this->username = $username;
        $this->firstname = $firstname;
    }
}