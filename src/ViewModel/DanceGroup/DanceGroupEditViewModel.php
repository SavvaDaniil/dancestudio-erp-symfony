<?php


namespace App\ViewModel\DanceGroup;

use App\ViewModel\Branch\BranchMicroViewModel;
use App\ViewModel\Teacher\TeacherMicroViewModel;

class DanceGroupEditViewModel {
    
    public int $id;
    public ?string $name;

    public int $teacher_id;
    //public ?TeacherMicroViewModel $teacherMicroViewModel;
    public ?array $teacherMicroViewModels;

    //daysOfWeek
    public ?array $danceGroupDayOfWeekLiteViewModels;

    public ?string $description;
    public int $status;
    public int $status_for_app;
    public int $status_of_creative;

    //public ?BranchMicroViewModel $branchMicroViewModel;
    public int $branch_id;
    public ?array $branchMicroViewModels;

    public int $is_active_reservation;
    public int $is_event;

    //DanceGroupEvents

    public int $is_abonements_allow_all;
    public ?array $connectionAbonementToDanceGroupLiteViewModels;//ConnectionAbonementToDanceGroupLiteViewModel[]
    public ?array $abonementLiteViewModels;//AbonementLiteViewModel[]

    public function __construct(
        int $id,
        ?string $name,
        int $teacher_id,
        ?array $teacherMicroViewModels,
        ?array $danceGroupDayOfWeekLiteViewModels,
        ?string $description,
        int $status,
        int $status_for_app,
        int $status_of_creative,
        int $branch_id,
        ?array $branchMicroViewModels,
        int $is_active_reservation,
        int $is_event,
        int $is_abonements_allow_all,
        ?array $connectionAbonementToDanceGroupLiteViewModels,
        ?array $abonementLiteViewModels
    ){
        $this->id = $id;
        $this->name = $name;
        $this->teacher_id = $teacher_id;
        $this->teacherMicroViewModels = $teacherMicroViewModels;
        $this->danceGroupDayOfWeekLiteViewModels = $danceGroupDayOfWeekLiteViewModels;
        $this->description = $description;
        $this->status = $status;
        $this->status_for_app = $status_for_app;
        $this->status_of_creative = $status_of_creative;
        $this->branch_id = $branch_id;
        $this->branchMicroViewModels = $branchMicroViewModels;
        $this->is_active_reservation = $is_active_reservation;
        $this->is_event = $is_event;
        $this->is_abonements_allow_all = $is_abonements_allow_all;
        $this->connectionAbonementToDanceGroupLiteViewModels = $connectionAbonementToDanceGroupLiteViewModels;
        $this->abonementLiteViewModels = $abonementLiteViewModels;
    }

}