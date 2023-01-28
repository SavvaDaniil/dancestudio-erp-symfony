<?php

namespace App\ViewModel\DanceGroup;

use App\ViewModel\Teacher\TeacherMicroViewModel;

class DanceGroupEditPreviewViewModel {

    public int $id;
    public ?string $name;
    public ?TeacherMicroViewModel $teacherMicroViewModel;
    public int $status;
    public int $status_for_app;

    public function __construct(int $id, ?string $name, ?TeacherMicroViewModel $teacherMicroViewModel, int $status, int $status_for_app)
    {
        $this->id = $id;
        $this->name = $name;
        $this->teacherMicroViewModel = $teacherMicroViewModel;
        $this->status = $status;
        $this->status_for_app = $status_for_app;
    }
    
}