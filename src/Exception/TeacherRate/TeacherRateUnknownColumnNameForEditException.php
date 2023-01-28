<?php


namespace App\Exception\TeacherRate;

use RuntimeException;

class TeacherRateUnknownColumnNameForEditException extends RuntimeException {
    public function __construct(){
        parent::__construct("unknown column name for edit teacher_rate");
    }
}