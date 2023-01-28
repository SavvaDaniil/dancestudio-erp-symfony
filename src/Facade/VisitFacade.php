<?php

namespace App\Facade;

use App\DTO\Visit\VisitNewDTO;
use App\DTO\Visit\VisitPrepareDTO;
use App\Entity\DanceGroup;
use App\Entity\DanceGroupDayOfWeek;
use App\Entity\PurchaseAbonement;
use App\Entity\User;
use App\Entity\Visit;
use App\Exception\DanceGroup\DanceGroupNotFoundException;
use App\Exception\DanceGroupDayOfWeek\DanceGroupDayOfWeekNotFoundException;
use App\Exception\PurchaseAbonement\PurchaseAbonementNotFoundException;
use App\Factory\VisitFactory;
use App\Repository\DanceGroupDayOfWeekRepository;
use App\Repository\DanceGroupRepository;
use App\Repository\PurchaseAbonementRepository;
use App\Repository\TeacherSalaryRepository;
use App\Repository\UserRepository;
use App\Repository\VisitRepository;
use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\Visit\VisitLiteViewModel;
use App\ViewModel\Visit\VisitPrepareViewModel;
use DateTime;

class VisitFacade {

    public function __construct(
        private VisitRepository $visitRepository,
        private UserRepository $userRepository,
        private DanceGroupFacade $danceGroupFacade,
        private TeacherSalaryFacade $teacherSalaryFacade,
        private DanceGroupRepository $danceGroupRepository,
        private DanceGroupDayOfWeekRepository $danceGroupDayOfWeekRepository,
        private AbonementFacade $abonementFacade,
        private PurchaseAbonementFacade $purchaseAbonementFacade,
        private PurchaseAbonementRepository $purchaseAbonementRepository,
        private UserFacade $userFacade,
    ){

    }

    public function listAllLiteByDanceGroupIdOnDateOfAction(int $danceGroupId, ?string $dateOfActionStr): JsonAnswerStatus {

        $danceGroup = null;
        if($danceGroupId != 0){
            $danceGroup = $this->danceGroupRepository->findById($danceGroupId);
            if($danceGroup == null)throw new DanceGroupNotFoundException();
        }

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->visitLiteViewModels = $this->listAllLiteByDanceGroupOnDateOfAction($danceGroup, $dateOfActionStr);
        return $jsonAnswerStatus;
    }

    public function listAllLiteByDanceGroupOnDateOfAction(DanceGroup $danceGroup, ?string $dateOfActionStr): array {
        $dateOfAction = null;
        if($dateOfActionStr != null && $dateOfActionStr != ""){
            $dateOfAction = new DateTime(date($dateOfActionStr));
        }
        $visits = $this->visitRepository->listAllByDanceGroupIdOnDateOfAction($danceGroup->getId(), $dateOfAction);
        $visitLiteViewModels = [];
        foreach($visits as $visit){
            array_push($visitLiteViewModels, ...);
        }
        return $visitLiteViewModels;
    }

    /**
     * @return VisitLiteViewModel[]
     */
    public function toListLiteViewModels(array $visits): array {
        $visitLiteViewModels = [];
        foreach($visits as $visit){
            array_push($visitLiteViewModels, ...);
        }
        return $visitLiteViewModels;
    }

    public function listAllLiteByUserIdAndCouldOnlyDanceGroupIdOnDateOfAction(int $userId, int $danceGroupId, ?string $dateOfActionStr): JsonAnswerStatus {
        $user = $this->userRepository->findById($userId);
        if($user == null)return new JsonAnswerStatus("error", "user_not_found");

        $danceGroup = null;
        if($danceGroupId != 0){
            $danceGroup = $this->danceGroupRepository->findById($danceGroupId);
            if($danceGroup == null)throw new DanceGroupNotFoundException();
        }
        $dateOfAction = null;
        if($dateOfActionStr != null && $dateOfActionStr != ""){
            $dateOfAction = new DateTime(date($dateOfActionStr));
        }

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->visitLiteViewModels = $this->listAllLiteByUserAndCouldOnlyOnDanceGroupOnDateOfAction($user, $danceGroup, $dateOfAction);
        return $jsonAnswerStatus;
    }

    public function listAllLiteByUserAndCouldOnlyOnDanceGroupOnDateOfAction(User $user, ?DanceGroup $danceGroup, ?DateTime $dateOfAction): array {
        $visits = [];
        if($danceGroup != null && $dateOfAction != null){
            $visits = $this->visitRepository->listAllByUserIdAndDanceGroupIdOnDateOfAction($user->getId(), $danceGroup->getId(), $dateOfAction);
        } else {
            $visits = $this->visitRepository->listAllByUserId($user->getId());
        }
        $visitLiteViewModels = [];
        foreach($visits as $visit){
            array_push($visitLiteViewModels, $this->toLiteViewModel($visit));
        }
        return $visitLiteViewModels;
    }

    public function addByAdmin(VisitNewDTO $visitNewDTO): JsonAnswerStatus {
        $user = $this->userRepository->findById($visitNewDTO->getUserId());
        if($user == null)return new JsonAnswerStatus("error", "user_not_found");

        $danceGroup = $this->danceGroupRepository->findById($visitNewDTO->getDanceGroupId());
        if($danceGroup == null)throw new DanceGroupNotFoundException();

        $purchaseAbonement = $this->purchaseAbonementRepository->findByIdAndUserId($visitNewDTO->getPurchaseAbonementId(), $user->getId());
        if($purchaseAbonement == null)throw new PurchaseAbonementNotFoundException();
        if($purchaseAbonement->getVisitsLeft() <= 0)return new JsonAnswerStatus("error", "out_of_limit_of_visits");

        $dateOfAction = new DateTime(date($visitNewDTO->getDateOfActionStr()));
        if($purchaseAbonement->getDateOfMustBeUsedTo() != null){
            if($purchaseAbonement->getDateOfMustBeUsedTo() < $dateOfAction)return new JsonAnswerStatus("error", "out_of_date_must_be_used_to");
        }

        if(!$this->add($user, $danceGroup, $purchaseAbonement, $visitNewDTO->getDateOfActionStr())){
            return new JsonAnswerStatus("error", null);
        }

        return new JsonAnswerStatus("success", null);
    }

    public function add(User $user, DanceGroup $danceGroup, PurchaseAbonement $purchaseAbonement, string $dateOfActionStr): bool {

        $dateOfAction = new DateTime(date($dateOfActionStr));
        $danceGroupDayOfWeek = $this->danceGroupDayOfWeekRepository->findByDanceGroupIdAndDayOfWeek(
            $danceGroup->getId(),
            $dateOfAction->format("N")
        );
        if($danceGroupDayOfWeek == null)throw new DanceGroupDayOfWeekNotFoundException();

        $visitFactory = new VisitFactory();
        $visit = $visitFactory->createByAdmin(
            $user,
            $danceGroup,
            $danceGroupDayOfWeek,
            $purchaseAbonement,
            $dateOfActionStr
        );
        $this->visitRepository->save($visit);

        ...

        ...

        return true;
    }

    public function deleteByAdmin(int $visitId): JsonAnswerStatus {
        $visit = $this->visitRepository->findById($visitId);
        if($visit == null)return new JsonAnswerStatus("error", "visit_not_found");

        $purchaseAbonement = $visit->getPurchaseAbonement();

        $this->visitRepository->remove($visit);
        if($purchaseAbonement != null){
            ...
        }

        $this->teacherSalaryFacade->autoUpdateAllGroupsOnDateOfAction($purchaseAbonement->getDateOfBuy()->format("Y-m-d"));

        return new JsonAnswerStatus("success", null);
    } 

    public function prepareForUserByAdmin(VisitPrepareDTO $visitPrepareDTO): JsonAnswerStatus {
        $user = $this->userRepository->findById($visitPrepareDTO->getUserId());
        if($user == null)return new JsonAnswerStatus("error", "user_not_found");

        $danceGroup = $this->danceGroupRepository->findById($visitPrepareDTO->getDanceGroupId());
        if($danceGroup == null)throw new DanceGroupNotFoundException();

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $dateOfAction = new DateTime(date($visitPrepareDTO->getDateOfActionStr()));
        $jsonAnswerStatus->visitPrepareViewModel = $this->getPrepare($user, $danceGroup, $dateOfAction);
        return $jsonAnswerStatus;
    } 

    public function getPrepare(User $user, DanceGroup $danceGroup, DateTime $dateOfAction): VisitPrepareViewModel {

        $userMicroViewModel = $this->userFacade->toMicroViewmodel($user);
        $danceGroupPreviewViewModel = $this->danceGroupFacade->toPreviewViewModel($danceGroup);
        $abonementLiteViewModels = $this->abonementFacade->listAllLiteActiveForUserAndDanceGroup($user, $danceGroup);
        $purchaseAbonementLiteViewModels = $this->purchaseAbonementFacade->listAllLiteActiveByUserAndDanceGroupIdAndDateOfAction(
            $user, 
            $danceGroup->getId(),
            $dateOfAction
        );
        $visitLiteViewModels = $this->listAllLiteByUserAndCouldOnlyOnDanceGroupOnDateOfAction($user, $danceGroup, $dateOfAction);

        return new VisitPrepareViewModel(
            $userMicroViewModel,
            $danceGroupPreviewViewModel,
            $abonementLiteViewModels,
            $purchaseAbonementLiteViewModels,
            $visitLiteViewModels
        );
    } 

    public function toLiteViewModel(Visit $visit): VisitLiteViewModel {
        return new VisitLiteViewModel(
            $visit->getId(),
            $visit->getDateOfBuy(),
            ($visit->getUser() != null ? $this->userFacade->toMicroViewmodel($visit->getUser()) : null),
            ($visit->getDanceGroup() != null ? $this->danceGroupFacade->toPreviewViewModel($visit->getDanceGroup()) : null),
            ($visit->getPurchaseAbonement() != null ? $this->purchaseAbonementFacade->toLiteViewModel($visit->getPurchaseAbonement()) : null),
            $visit->getIsReservation(),
            $visit->getStatusOfReservation(),
            $visit->getDateOfAcceptOfReservation(),
            $visit->getVisitsLeft()
        );
    }


}