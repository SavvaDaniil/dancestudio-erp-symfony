<?php


namespace App\ViewModel\TeacherRate;

class TeacherRateLiteViewModel {

    public int $id;
    public int $students;
    public int $price;

    public function __construct(int $id, int $students, int $price){
        $this->id = $id;
        $this->students = $students;
        $this->price = $price;
    }
    
}