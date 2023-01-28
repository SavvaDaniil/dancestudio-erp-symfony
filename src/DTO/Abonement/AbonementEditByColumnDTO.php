<?php

namespace App\DTO\Abonement;

class AbonementEditByColumnDTO {

    private int $abonement_id;
    private string $name;
    private string $value;

    public function __construct(int $abonement_id, string $name, string $value){
        $this->$abonement_id = $abonement_id;
        $this->$name = $name;
        $this->$value = $value;
    }
    

    /**
     * Get the value of abonement_id
     */ 
    public function getAbonement_id()
    {
        return $this->abonement_id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }
}