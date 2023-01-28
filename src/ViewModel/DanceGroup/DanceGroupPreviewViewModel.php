<?php

namespace App\ViewModel\DanceGroup;

use App\ViewModel\Teacher\TeacherMicroViewModel;

class DanceGroupPreviewViewModel extends DanceGroupMicroViewModel {

    //public int $id;
    //public ?string $name;
    public ?TeacherMicroViewModel $teacherMicroViewModel;

    public function __construct(int $id, ?string $name, ?TeacherMicroViewModel $teacherMicroViewModel)
    {
        //$this->id = $id;
        //$this->name = $name;
        parent::__construct($id, $name);
        $this->teacherMicroViewModel = $teacherMicroViewModel;
    }

}