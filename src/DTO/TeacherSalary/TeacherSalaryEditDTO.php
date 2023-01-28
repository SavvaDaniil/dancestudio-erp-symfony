<?php

namespace App\DTO\TeacherSalary;

class TeacherSalaryEditDTO {

    private int $teacherSalaryId;
    private string $name;
    private int $value;

    public function __construct(
        int $teacherSalaryId,
        string $name,
        int $value
    ){
        $this->teacherSalaryId = $teacherSalaryId;
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * Get the value of teacherSalaryId
     */ 
    public function getTeacherSalaryId(): int
    {
        return $this->teacherSalaryId;
    }

    /**
     * Get the value of name
     */ 
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the value of value
     */ 
    public function getValue(): int
    {
        return $this->value;
    }
}