<?php


namespace App\Exception\TeacherRate;

use RuntimeException;

class TeacherRateUnknownSpecialException extends RuntimeException {
    public function __construct(){
        parent::__construct("unknown special for teacher_rate");
    }
}