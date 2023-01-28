<?php

namespace App\DTO\TeacherSalary;

use App\ViewModel\DanceGroup\DanceGroupMicroViewModel;
use App\ViewModel\Teacher\TeacherMicroViewModel;
use DateTime;

class TeacherSalaryInfoViewModel {

    public int $id;
    public ?DateTime $date_of_action;
    public ?DanceGroupMicroViewModel $danceGroupMicroViewModel;
    public ?TeacherMicroViewModel $teacherMicroViewModel;
    public int $visits_count;
    public int $price_auto;
    public int $is_changed_by_admin;
    public int $price_fact;
    public int $status;

    public function __construct(
        int $id,
        DateTime $date_of_action,
        ?DanceGroupMicroViewModel $danceGroupMicroViewModel,
        ?TeacherMicroViewModel $teacherMicroViewModel,
        int $visits_count,
        int $price_auto,
        int $is_changed_by_admin,
        int $price_fact,
        int $status
    ){
        $this->id = $id;
        $this->date_of_action = $date_of_action;
        $this->danceGroupMicroViewModel = $danceGroupMicroViewModel;
        $this->teacherMicroViewModel = $teacherMicroViewModel;
        $this->visits_count = $visits_count;
        $this->price_auto = $price_auto;
        $this->is_changed_by_admin = $is_changed_by_admin;
        $this->price_fact = $price_fact;
        $this->status = $status;
    }



}