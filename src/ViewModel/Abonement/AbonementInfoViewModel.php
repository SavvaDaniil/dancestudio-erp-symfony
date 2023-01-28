<?php

namespace App\ViewModel\Abonement;


class AbonementInfoViewModel {

    public int $id;
    public ?string $name;
    public ?string $special_status;
    public int $days;
    public int $price;
    public int $visits;
    public int $status_of_visible;
    public int $status_of_deleted;
    public int $status_for_app;
    public int $is_trial;
    public int $is_private;
    
    public function __construct(
        int $id,
        ?string $name,
        ?string $special_status,
        int $days,
        int $price,
        int $visits,
        int $status_of_visible,
        int $status_of_deleted,
        int $status_for_app,
        int $is_trial,
        int $is_private
    ){
        $this->id = $id;
        $this->name = $name;
        $this->special_status = $special_status;
        $this->days = $days;
        $this->price = $price;
        $this->visits = $visits;
        $this->status_of_visible = $status_of_visible;
        $this->status_of_deleted = $status_of_deleted;
        $this->status_for_app = $status_for_app;
        $this->is_trial = $is_trial;
        $this->is_private = $is_private;
    }

}