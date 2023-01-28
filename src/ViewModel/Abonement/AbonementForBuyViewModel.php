<?php

namespace App\ViewModel\Abonement;

class AbonementForBuyViewModel {
    
    public int $id;
    public ?string $name;
    public ?string $special_status;
    public int $days;
    public int $price;
    public int $visits;
    public int $is_trial;
    
    public function __construct(
        int $id,
        ?string $name,
        ?string $special_status,
        int $days,
        int $price,
        int $visits,
        int $is_trial
    ){
        $this->id = $id;
        $this->name = $name;
        $this->special_status = $special_status;
        $this->days = $days;
        $this->price = $price;
        $this->visits = $visits;
        $this->is_trial = $is_trial;
    }

}