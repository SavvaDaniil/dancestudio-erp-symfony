<?php

namespace App\ViewModel\Teacher;

class TeacherMicroViewModel {
    
    public int $id;
    public ?string $name;

    public function __construct(int $id, ?string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

}