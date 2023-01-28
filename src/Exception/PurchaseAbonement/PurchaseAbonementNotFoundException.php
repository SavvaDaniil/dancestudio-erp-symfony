<?php

namespace App\Exception\PurchaseAbonement;

use RuntimeException;

class PurchaseAbonementNotFoundException extends RuntimeException {
    public function __construct(){
        parent::__construct("purchase_abonement not found");
    }
}