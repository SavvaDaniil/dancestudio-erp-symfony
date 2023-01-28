<?php

namespace App\Factory;

use App\Entity\DanceGroup;
use App\Entity\Teacher;
use App\Entity\TeacherSalary;
use DateTime;

class TeacherSalaryFactory {
    
    public function create(Teacher $teacher, DanceGroup $danceGroup, string $dateOfActionStr): TeacherSalary {
        $teacherSalary = new TeacherSalary();
        $teacherSalary->setTeacher($teacher);
        $teacherSalary->setDanceGroup($danceGroup);
        $teacherSalary->setDateOfAction(new DateTime(date($dateOfActionStr)));
        $teacherSalary->setStatus(1);
        $teacherSalary->setPriceAuto(0);
        $teacherSalary->setPriceFact(0);
        $teacherSalary->setIsChangedByAdmin(0);

        $dateOfAdd = new DateTime(date("Y-m-d H:i:s"));
        $teacherSalary->setDateOfAdd($dateOfAdd);
        $teacherSalary->setDateOfUpdate($dateOfAdd);

        return $teacherSalary;
    }
    

}