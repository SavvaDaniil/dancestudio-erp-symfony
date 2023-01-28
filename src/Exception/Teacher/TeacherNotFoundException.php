<?php

namespace App\Exception\Teacher;

use RuntimeException;

class TeacherNotFoundException extends RuntimeException {
    public function __construct(){
        parent::__construct("teacher not found");
    }
}