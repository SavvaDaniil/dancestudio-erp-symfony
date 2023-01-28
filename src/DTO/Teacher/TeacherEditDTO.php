<?php


namespace App\DTO\Teacher;


class TeacherEditDTO {
    
    private int $teacher_id;
    private ?string $name;
    private int $stavka;
    private int $min_students;
    private int $raz;
    private int $usual;
    private int $unlim;
    private int $stavka_plus;
    private int $plus_after_students;
    private int $plus_after_summa;
    private int $procent;

    public function __construct(
        int $teacher_id,
        ?string $name,
        int $stavka,
        int $min_students,
        int $raz,
        int $usual,
        int $unlim,
        int $stavka_plus,
        int $plus_after_students,
        int $plus_after_summa,
        int $procent
    ){
        $this->teacher_id = $teacher_id;
        $this->name = $name;
        $this->stavka = $stavka;
        $this->min_students = $min_students;
        $this->raz = $raz;
        $this->usual = $usual;
        $this->unlim = $unlim;
        $this->stavka_plus = $stavka_plus;
        $this->plus_after_students = $plus_after_students;
        $this->plus_after_summa = $plus_after_summa;
        $this->procent = $procent;
    }

    

    /**
     * Get the value of teacher_id
     */ 
    public function getTeacher_id()
    {
        return $this->teacher_id;
    }


    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the value of stavka
     */ 
    public function getStavka()
    {
        return $this->stavka;
    }

    /**
     * Get the value of min_students
     */ 
    public function getMin_students()
    {
        return $this->min_students;
    }

    /**
     * Get the value of raz
     */ 
    public function getRaz()
    {
        return $this->raz;
    }

    /**
     * Get the value of usual
     */ 
    public function getUsual()
    {
        return $this->usual;
    }

    /**
     * Get the value of unlim
     */ 
    public function getUnlim()
    {
        return $this->unlim;
    }

    /**
     * Get the value of stavka_plus
     */ 
    public function getStavka_plus()
    {
        return $this->stavka_plus;
    }

    /**
     * Get the value of plus_after_students
     */ 
    public function getPlus_after_students()
    {
        return $this->plus_after_students;
    }

    /**
     * Get the value of plus_after_summa
     */ 
    public function getPlus_after_summa()
    {
        return $this->plus_after_summa;
    }

    /**
     * Get the value of procent
     */ 
    public function getProcent()
    {
        return $this->procent;
    }
}