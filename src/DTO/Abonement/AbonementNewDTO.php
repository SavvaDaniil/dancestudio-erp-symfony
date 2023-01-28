<?php

namespace App\DTO\Abonement;

class AbonementNewDTO {

    private string $special_status;
    private bool $is_trial;

    public function __construct(string $special_status, int $is_trial){
        $this->special_status = $special_status;
        $this->is_trial = $is_trial;
    }

    /**
     * Get the value of special_status
     */ 
    public function getSpecial_status()
    {
        return $this->special_status;
    }

    /**
     * Get the value of is_trial
     */ 
    public function getIs_trial()
    {
        return $this->is_trial;
    }

}