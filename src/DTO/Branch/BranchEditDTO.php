<?php

namespace App\DTO\Branch;

class BranchEditDTO {

    private int $branch_id;
    private ?string $name;
    private ?string $coordinates;
    private ?string $description;

    public function __construct(int $branch_id, ?string $name, ?string $coordinates, ?string $description){
        $this->branch_id = $branch_id;
        $this->name = $name;
        $this->coordinates = $coordinates;
        $this->description = $description;
    }


    /**
     * Get the value of branch_id
     */ 
    public function getBranch_id()
    {
        return $this->branch_id;
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