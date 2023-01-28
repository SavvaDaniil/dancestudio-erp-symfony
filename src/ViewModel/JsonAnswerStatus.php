<?php


namespace App\ViewModel;

use App\ViewModel\Abonement\AbonementForBuyViewModel;
use App\ViewModel\Admin\AdminProfileViewModel;
use App\ViewModel\Branch\BranchInfoViewModel;
use App\ViewModel\DanceGroup\DanceGroupEditViewModel;
use App\ViewModel\PurchaseAbonement\PurchaseAbonementLiteViewModel;
use App\ViewModel\Teacher\TeacherInfoViewModel;
use App\ViewModel\TeacherSalary\TeacherSalaryMoreInfoViewModel;
use App\ViewModel\TeacherSalary\TeacherSalarySearchPrepareViewModel;
use App\ViewModel\User\UserProfileViewModel;
use App\ViewModel\User\UserSearchPreviewViewModel;
use App\ViewModel\Visit\VisitPrepareViewModel;

//use App\ViewModel\Abonement\AbonementInfoViewModel;

class JsonAnswerStatus {
    public ?string $status;
    public ?string $errors;

    public function __construct(?string $status, ?string $errors = null){
        $this->status = $status;
        $this->errors = $errors;
    }

    public ?string $access_token;
    public ?AdminProfileViewModel $adminProfileViewModel;
    public bool $isNeedRelogin = false;

    public ?array $abonementInfoViewModels;//AbonementInfoViewModel[]
    public ?array $abonementLiteViewModels;//AbonementLiteViewModel[]
    public ?AbonementForBuyViewModel $abonementForBuyViewModel;
    
    public ?array $teacherLiteViewModels;//TeacherLiteViewModel[]
    public ?TeacherInfoViewModel $teacherInfoViewModel;

    public ?array $branchLiteViewModels;//BranchLiteViewModel[]
    public ?BranchInfoViewModel $branchInfoViewModel;
    
    public ?array $danceGroupEditPreviewViewModels;//DanceGroupEditPreviewViewModel[]
    public ?DanceGroupEditViewModel $danceGroupEditViewModel;
    public ?array $danceGroupLessonViewModels;//DanceGroupLessonViewModel[]

    public ?array $userSearchPreviewViewModels;//UserSearchPreviewViewModel
    public ?UserProfileViewModel $userProfileViewModel;

    public ?int $countUserSearchQuery;
    public ?UserSearchPreviewViewModel $userSearchPreviewViewModel;

    public ?array $purchaseAbonementLiteViewModels;//PurchaseAbonementLiteViewModel[]
    public ?PurchaseAbonementLiteViewModel $purchaseAbonementLiteViewModel;
    
    public ?VisitPrepareViewModel $visitPrepareViewModel;
    public ?array $visitLiteViewModels;//VisitLiteViewModel[]

    public ?array $teacherSalaryLiteViewModels;//TeacherSalaryLiteViewModel[]
    public ?TeacherSalaryMoreInfoViewModel $teacherSalaryMoreInfoViewModel;

    public ?TeacherSalarySearchPrepareViewModel $teacherSalarySearchPrepareViewModel;

    
}