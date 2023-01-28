<?php

namespace App\DTO\Teacher;

class TeacherNewDTO {
    
    private string $name;

    public function __construct(string $name){
        $this->name = $name;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }
}