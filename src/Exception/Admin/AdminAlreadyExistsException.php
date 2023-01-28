<?php

namespace App\Exception\Admin;

use RuntimeException;

class AdminAlreadyExistsException extends RuntimeException {

    public function __construct(){
        parent::__construct("admin already exists");
    }

}