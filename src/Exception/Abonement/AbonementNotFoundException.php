<?php


namespace App\Exception\Abonement;

use RuntimeException;

class AbonementNotFoundException extends RuntimeException {
    public function __construct(){
        parent::__construct("abonement not found");
    }
}