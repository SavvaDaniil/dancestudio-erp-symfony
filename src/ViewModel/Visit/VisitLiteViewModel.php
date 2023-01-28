<?php

namespace App\ViewModel\Visit;

use App\ViewModel\DanceGroup\DanceGroupPreviewViewModel;
use App\ViewModel\PurchaseAbonement\PurchaseAbonementLiteViewModel;
use App\ViewModel\User\UserMicroViewModel;

use DateTime;

class VisitLiteViewModel {

    public int $id;
    public DateTime $date_of_action;
    public ?UserMicroViewModel $userMicroViewModel;
    public ?DanceGroupPreviewViewModel $danceGroupPreviewViewModel;
    public ?PurchaseAbonementLiteViewModel $purchaseAbonementLiteViewModel;

    public int $is_reservation;
    public int $status_of_reservation;
    public ?DateTime $date_of_accept_of_reservation;
    public int $visits_left;

    public function __construct(
        int $id,
        DateTime $date_of_action,
        ?UserMicroViewModel $userMicroViewModel,
        ?DanceGroupPreviewViewModel $danceGroupPreviewViewModel,
        ?PurchaseAbonementLiteViewModel $purchaseAbonementLiteViewModel,
        int $is_reservation,
        int $status_of_reservation,
        ?DateTime $date_of_accept_of_reservation,
        int $visits_left
    )
    {
        $this->id = $id;
        $this->date_of_action = $date_of_action;
        $this->userMicroViewModel = $userMicroViewModel;
        $this->danceGroupPreviewViewModel = $danceGroupPreviewViewModel;
        $this->purchaseAbonementLiteViewModel = $purchaseAbonementLiteViewModel;
        $this->is_reservation = $is_reservation;
        $this->status_of_reservation = $status_of_reservation;
        $this->date_of_accept_of_reservation = $date_of_accept_of_reservation;
        $this->visits_left = $visits_left;
    }

}