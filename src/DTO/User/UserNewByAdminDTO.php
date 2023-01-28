<?php

namespace App\DTO\User;

class UserNewByAdminDTO {

    private string $secondname;
    private string $firstname;
    private ?string $telephone;
    private ?string $comment;

    public function __construct(string $secondname, string $firstname, ?string $telephone, ?string $comment){
        $this->secondname = $secondname;
        $this->firstname = $firstname;
        $this->telephone = $telephone;
        $this->comment = $comment;
    }

    /**
     * Get the value of secondname
     */ 
    public function getSecondname()
    {
        return $this->secondname;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the value of telephone
     */ 
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get the value of comment
     */ 
    public function getComment()
    {
        return $this->comment;
    }
}