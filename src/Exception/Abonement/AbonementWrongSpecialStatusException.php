<?php


namespace App\Exception\Abonement;

use RuntimeException;

class AbonementWrongSpecialStatusException extends RuntimeException {

    public function __construct(){
        parent::__construct("wrong special status");
    }

}