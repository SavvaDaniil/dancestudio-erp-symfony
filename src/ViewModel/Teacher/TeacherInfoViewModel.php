<?php

namespace App\ViewModel\Teacher;

use App\ViewModel\TeacherRate\TeacherRateLiteViewModel;

class TeacherInfoViewModel {

    public int $id;
    public ?string $name;
    public ?string $poster_src;
    public int $stavka;
    public int $min_students;
    public int $raz;
    public int $usual;
    public int $unlim;
    public int $stavka_plus;
    public int $plus_after_students;
    public int $plus_after_summa;
    public int $procent;
    private ?array $teacherRateLiteViewModels;// TeacherRateLiteViewModel[]

    public function __construct(
        int $id,
        ?string $name,
        ?string $poster_src,
        int $stavka,
        int $min_students,
        int $raz,
        int $usual,
        int $unlim,
        int $stavka_plus,
        int $plus_after_students,
        int $plus_after_summa,
        int $procent
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->poster_src = $poster_src;
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
     * @return TeacherRateLiteViewModel[]
     */ 
    public function getTeacherRateLiteViewModels(): ?array
    {
        return $this->teacherRateLiteViewModels;
    }

    /**
     * Set the value of teacherRateLiteViewModels
     *
     * @return  self
     */ 
    public function setTeacherRateLiteViewModels(?array $teacherRateLiteViewModels)
    {
        $this->teacherRateLiteViewModels = $teacherRateLiteViewModels;

        return $this;
    }
}