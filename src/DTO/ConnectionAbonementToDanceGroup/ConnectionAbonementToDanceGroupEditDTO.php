<?php

namespace App\DTO\ConnectionAbonementToDanceGroup;

class ConnectionAbonementToDanceGroupEditDTO {

    private int $dance_group_id;
    private int $abonement_id;
    private int $value;

    public function __construct(int $dance_group_id, int $abonement_id, int $value){
        $this->dance_group_id = $dance_group_id;
        $this->abonement_id = $abonement_id;
        $this->value = $value;
    }

    /**
     * Get the value of dance_group_id
     */ 
    public function getDance_group_id()
    {
        return $this->dance_group_id;
    }

    /**
     * Get the value of abonement_id
     */ 
    public function getAbonement_id()
    {
        return $this->abonement_id;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }
}