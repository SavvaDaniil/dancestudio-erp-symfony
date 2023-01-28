<?php


namespace App\Exception\DanceGroup;

use RuntimeException;

class DanceGroupNotFoundException extends RuntimeException {
    public function __construct(){
        parent::__construct("dance_group not found");
    }
}