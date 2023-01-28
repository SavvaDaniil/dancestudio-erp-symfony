<?php

namespace App\DTO\TeacherRate;


class TeacherRateNewDTO {

    private int $teacher_id;
    private int $students;
    private int $how_much_money;

    public function __construct(int $teacher_id, int $students, int $how_much_money){
        $this->teacher_id = $teacher_id;
        $this->students = $students;
        $this->how_much_money = $how_much_money;
    }

    /**
     * Get the value of teacher_id
     */ 
    public function getTeacher_id()
    {
        return $this->teacher_id;
    }

    /**
     * Get the value of students
     */ 
    public function getStudents()
    {
        return $this->students;
    }

    /**
     * Get the value of how_much_money
     */ 
    public function getHow_much_money()
    {
        return $this->how_much_money;
    }
}