<?php

namespace App\ViewModel\TeacherSalary;

class TeacherSalarySearchPrepareViewModel {

    public array $danceGroupMicroViewModel;//DanceGroupMicroViewModel[]
    public array $teacherMicroViewModel;//TeacherMicroViewModel[]

    public function __construct(
        array $danceGroupMicroViewModel,
        array $teacherMicroViewModel
    )
    {
        $this->danceGroupMicroViewModel = $danceGroupMicroViewModel;
        $this->teacherMicroViewModel = $teacherMicroViewModel;
    }
    
}