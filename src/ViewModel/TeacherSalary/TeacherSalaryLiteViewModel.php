<?php

namespace App\DTO\TeacherSalary;

use App\ViewModel\DanceGroup\DanceGroupMicroViewModel;
use App\ViewModel\Teacher\TeacherMicroViewModel;
use DateTime;

class TeacherSalaryLiteViewModel {

    public int $id;
    public ?DateTime $date_of_action;
    public ?DanceGroupMicroViewModel $danceGroupMicroViewModel;
    public ?TeacherMicroViewModel $teacherMicroViewModel;
    public int $visits_count;
    public int $price;
    public int $status;

    public function __construct(
        int $id,
        DateTime $date_of_action,
        ?DanceGroupMicroViewModel $danceGroupMicroViewModel,
        ?TeacherMicroViewModel $teacherMicroViewModel,
        int $visits_count,
        int $price,
        int $status
    ){
        $this->id = $id;
        $this->date_of_action = $date_of_action;
        $this->danceGroupMicroViewModel = $danceGroupMicroViewModel;
        $this->teacherMicroViewModel = $teacherMicroViewModel;
        $this->visits_count = $visits_count;
        $this->price = $price;
        $this->status = $status;
    }



}