<?php

namespace App\Exception\TeacherRate;

use RuntimeException;

class TeacherRateNotFoundException extends RuntimeException {
    public function __construct(){
        parent::__construct("teacher_rate not found");
    }
}