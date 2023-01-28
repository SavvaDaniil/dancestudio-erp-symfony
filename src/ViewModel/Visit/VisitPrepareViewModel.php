<?php

namespace App\ViewModel\Visit;

use App\ViewModel\DanceGroup\DanceGroupPreviewViewModel;
use App\ViewModel\User\UserMicroViewModel;

class VisitPrepareViewModel {

    public UserMicroViewModel $userMicroViewModel;
    public DanceGroupPreviewViewModel $danceGroupPreviewViewModel;
    public array $abonementLiteViewModels;
    public array $purchaseAbonementLiteViewModels;
    public array $visitLiteViewModels;

    public function __construct(
        UserMicroViewModel $userMicroViewModel,
        DanceGroupPreviewViewModel $danceGroupPreviewViewModel,
        array $abonementLiteViewModels,
        array $purchaseAbonementLiteViewModels,
        array $visitLiteViewModels
    )
    {
        $this->userMicroViewModel = $userMicroViewModel;
        $this->danceGroupPreviewViewModel = $danceGroupPreviewViewModel;
        $this->abonementLiteViewModels = $abonementLiteViewModels;
        $this->purchaseAbonementLiteViewModels = $purchaseAbonementLiteViewModels;
        $this->visitLiteViewModels = $visitLiteViewModels;
    }
}