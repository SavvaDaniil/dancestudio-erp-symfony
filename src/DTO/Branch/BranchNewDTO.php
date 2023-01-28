<?php

namespace App\DTO\Branch;

class BranchNewDTO {
    
    private string $name;
    private ?string $coordinates;
    private ?string $description;

    public function __construct(string $name, ?string $coordinates, ?string $description){
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->description = $description;
    }


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of coordinates
     */ 
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }
}