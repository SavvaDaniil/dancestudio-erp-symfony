<?php

namespace App\ViewModel\TeacherSalary;

use App\DTO\TeacherSalary\TeacherSalaryInfoViewModel;

class TeacherSalaryMoreInfoViewModel {

    public TeacherSalaryInfoViewModel $teacherSalaryInfoViewModel;
    public array $visitLiteViewModels;//VisitLiteViewModel[]

    public function __construct(
        TeacherSalaryInfoViewModel $teacherSalaryInfoViewModel,
        array $visitLiteViewModels
    )
    {
        $this->teacherSalaryInfoViewModel = $teacherSalaryInfoViewModel;
        $this->visitLiteViewModels = $visitLiteViewModels;
    }
}