<?php

namespace App\ViewModel\PurchaseAbonement;

use App\ViewModel\Abonement\AbonementLiteViewModel;
use DateTime;

class PurchaseAbonementLiteViewModel {

    public int $id;
    public int $user_id;
    public int $abonement_id;
    public ?AbonementLiteViewModel $abonementLiteViewModel;
    public ?string $special_status;
    public int $price;
    public int $cashless;
    public int $visits_start;
    public int $visits_left;
    public int $days;
    public bool $isActiveForDanceGroup;
    public ?DateTime $date_of_buy;
    public ?DateTime $date_of_add;
    public ?DateTime $date_of_activation;
    public ?DateTime $date_of_must_be_used_to;

    public function __construct(
        int $id,
        int $user_id,
        int $abonement_id,
        ?AbonementLiteViewModel $abonementLiteViewModel,
        ?string $special_status,
        int $price,
        int $cashless,
        int $visits_start,
        int $visits_left,
        int $days,
        bool $isActiveForDanceGroup,
        ?DateTime $date_of_buy,
        ?DateTime $date_of_add,
        ?DateTime $date_of_activation,
        ?DateTime $date_of_must_be_used_to
    ){
        $this->id = $id;
        $this->user_id = $user_id;
        $this->abonement_id = $abonement_id;
        $this->abonementLiteViewModel = $abonementLiteViewModel;
        $this->special_status = $special_status;
        $this->price = $price;
        $this->cashless = $cashless;
        $this->visits_start = $visits_start;
        $this->visits_left = $visits_left;
        $this->days = $days;
        $this->isActiveForDanceGroup = $isActiveForDanceGroup;
        $this->date_of_buy = $date_of_buy;
        $this->date_of_add = $date_of_add;
        $this->date_of_activation = $date_of_activation;
        $this->date_of_must_be_used_to = $date_of_must_be_used_to;
    }


}