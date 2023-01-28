<?php

namespace App\DTO\DanceGroup;

class DanceGroupNewDTO {

    private string $name;

    public function __construct(string $name){
        $this->name = $name;
    }
    

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }
}