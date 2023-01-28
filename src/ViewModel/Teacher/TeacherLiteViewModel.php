<?php

use App\ViewModel\Teacher\TeacherMicroViewModel;

class TeacherLiteViewModel extends TeacherMicroViewModel {
    
    public bool $is_any_dance_group;

    public function __construct(int $id, ?string $name, bool $is_any_dance_group)
    {
        parent::__construct($id, $name);
        $this->is_any_dance_group = $is_any_dance_group;
    }
}