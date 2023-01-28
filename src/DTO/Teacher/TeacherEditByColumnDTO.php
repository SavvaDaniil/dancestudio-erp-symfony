<?php

namespace App\DTO\Teacher;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TeacherEditByColumnDTO{

    #[Assert\NotBlank]
    public int $teacher_id;

    #[Assert\NotBlank]
    public string $name;

    #[Assert\NotBlank]
    public string $value;
    
    public ?UploadedFile $file;

    /*
    public function __construct(int $teacher_id, string $name, ?string $value, ?UploadedFile $file){
        $this->teacher_id = $teacher_id;
        $this->name = $name;
        $this->value = $value;
        $this->file = $file;
    }
    */



    /**
     * Get the value of teacher_id
     */ 
    public function getTeacher_id()
    {
        return $this->teacher_id;
    }

    /**
     * Set the value of teacher_id
     *
     * @return  self
     */ 
    public function setTeacher_id($teacher_id)
    {
        $this->teacher_id = $teacher_id;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of value
     */ 
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set the value of value
     *
     * @return  self
     */ 
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /*
    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }
    */
}