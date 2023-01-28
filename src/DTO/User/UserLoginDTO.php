<?php

namespace App\DTO\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserLoginDTO {

    //#[Assert\NotBlank]
    public ?string $username;
    
    //#[Assert\NotBlank]
    public ?string $password;

}