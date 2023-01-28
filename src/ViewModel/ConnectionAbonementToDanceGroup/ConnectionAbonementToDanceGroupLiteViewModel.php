<?php

namespace App\ViewModel\ConnectionAbonementToDanceGroup;

use App\ViewModel\Abonement\AbonementLiteViewModel;

class ConnectionAbonementToDanceGroupLiteViewModel {
    
    public int $id;
    public int $abonement_id;
    public int $dance_group_id;

    public function __construct(int $id, int $abonement_id, int $dance_group_id)
    {
        $this->id = $id;
        $this->abonement_id = $abonement_id;
        $this->dance_group_id = $dance_group_id;
    }

}