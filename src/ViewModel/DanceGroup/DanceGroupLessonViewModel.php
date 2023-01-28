<?php

namespace App\ViewModel\DanceGroup;

use App\ViewModel\Teacher\TeacherMicroViewModel;

class DanceGroupLessonViewModel {

    public int $id;
    public ?string $name;
    public ?TeacherMicroViewModel $teacherMicroViewModel;
    public ?string $time_from;
    public ?string $time_to;

    public function __construct(int $id, ?string $name, ?TeacherMicroViewModel $teacherMicroViewModel, ?string $time_from, ?string $time_to)
    {
        $this->id = $id;
        $this->name = $name;
        $this->teacherMicroViewModel = $teacherMicroViewModel;
        $this->time_from = $time_from;
        $this->time_to = $time_to;
    }

}