<?php

namespace App\ViewModel\Abonement;

class AbonementLiteViewModel {
    
    public int $id;
    public ?string $name;
    public ?string $special_status;
    public int $price;
    
    public function __construct(
        int $id,
        ?string $name,
        ?string $special_status,
        int $price
    ){
        $this->id = $id;
        $this->name = $name;
        $this->special_status = $special_status;
        $this->price = $price;
    }

}