<?php

namespace App\DTO\TeacherRate;

class TeacherRateEditDTO {

    private int $teacher_rate_id;
    private string $name;
    private int $value;

    public function __construct(int $teacher_rate_id, string $name, int $value){
        $this->teacher_rate_id = $teacher_rate_id;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the value of teacher_rate_id
     */ 
    public function getTeacher_rate_id()
    {
        return $this->teacher_rate_id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }
}