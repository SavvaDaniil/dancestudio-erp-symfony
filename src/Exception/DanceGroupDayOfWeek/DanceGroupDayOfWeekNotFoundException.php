<?php

namespace App\Exception\DanceGroupDayOfWeek;

use RuntimeException;

class DanceGroupDayOfWeekNotFoundException extends RuntimeException {
    public function __construct(){
        parent::__construct("dance_group_day_of_week not found");
    }
}