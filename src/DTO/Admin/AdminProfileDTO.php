<?php


namespace App\DTO\Admin;

class AdminProfileDTO {
    
    private string $username;
    private ?string $firstname;
    private ?string $passwordNew;
    private ?string $passwordCurrent;

    public function __construct(string $username, ?string $firstname, ?string $passwordNew, ?string $passwordCurrent){
        $this->username = $username;
        $this->firstname = $firstname;
        $this->passwordNew = $passwordNew;
        $this->passwordCurrent = $passwordCurrent;
    }


    /**
     * Get the value of username
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the value of firstname
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the value of passwordNew
     */ 
    public function getPasswordNew()
    {
        return $this->passwordNew;
    }

    /**
     * Get the value of passwordCurrent
     */ 
    public function getPasswordCurrent()
    {
        return $this->passwordCurrent;
    }
}