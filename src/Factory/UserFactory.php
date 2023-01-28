<?php

namespace App\Factory;

use App\Entity\User;
use DateTime;

class UserFactory {

    public function createByAdmin(string $secondname, string $firstname, ?string $telephone, ?string $comment): User {
        ...
    }

}