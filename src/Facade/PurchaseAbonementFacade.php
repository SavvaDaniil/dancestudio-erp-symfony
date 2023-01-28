<?php

namespace App\Facade;

use App\Decorator\VisitFacadeDecorator;
use App\DTO\PurchaseAbonement\PurchaseAbonementEditDTO;
use App\DTO\PurchaseAbonement\PurchaseAbonementNewDTO;
use App\Entity\PurchaseAbonement;
use App\Entity\User;
use App\Exception\Abonement\AbonementNotFoundException;
use App\Exception\DanceGroup\DanceGroupNotFoundException;
use App\Exception\PurchaseAbonement\PurchaseAbonementNotFoundException;
use App\Factory\PurchaseAbonementFactory;
use App\Repository\AbonementRepository;
use App\Repository\DanceGroupRepository;
use App\Repository\PurchaseAbonementRepository;
use App\Repository\UserRepository;
use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\PurchaseAbonement\PurchaseAbonementLiteViewModel;
use DateTime;

class PurchaseAbonementFacade {

    public function __construct(
        private AbonementFacade $abonementFacade,
        private VisitFacade $visitFacade,
        private PurchaseAbonementRepository $purchaseAbonementRepository,
        private UserRepository $userRepository,
        private AbonementRepository $abonementRepository,
        private DanceGroupRepository $danceGroupRepository,
    ){

    }

    public function minusVisit(PurchaseAbonement $purchaseAbonement, string $dateOfActionStr): bool {
        $dateOfAction = new DateTime(date($dateOfActionStr));
        if($purchaseAbonement->getVisitsLeft() <= 0)return false;

        if($purchaseAbonement->getDateOfActivation() == null){
            $purchaseAbonement->setDateOfActivation(new DateTime(date($dateOfActionStr)));
        }

        if($purchaseAbonement->getDateOfMustBeUsedTo() != null){
            ...
        } else {
            $dateOfMustBeUsedTo = new DateTime(date($purchaseAbonement->getDateOfActivation()->format("Y-m-d")));
            ...
        }

        ...
        
        $this->purchaseAbonementRepository->save($purchaseAbonement, true);
        return true;
    }

    public function recoveryVisit(PurchaseAbonement $purchaseAbonement): bool {

        if($purchaseAbonement->getVisitsLeft() + 1 > $purchaseAbonement->getVisitsStart())return false;

        $purchaseAbonement->setVisitsLeft($purchaseAbonement->getVisitsLeft() + 1);
        if($purchaseAbonement->getVisitsLeft() == $purchaseAbonement->getVisitsStart()){
            $purchaseAbonement->setDateOfActivation(null);
            $purchaseAbonement->setDateOfMustBeUsedTo(null);
        }
        
        $this->purchaseAbonementRepository->save($purchaseAbonement, true);

        ...

        return true;
    }

    public function listAllLiteActiveByUserIdAndDanceGroupIdAndDateOfAction(int $userId, int $danceGroupId, string $dateOfActionStr): JsonAnswerStatus {
        $user = $this->userRepository->findById($userId);
        if($user == null)return new JsonAnswerStatus("error", "user_not_found");

        $dateOfAction = new DateTime(date($dateOfActionStr));

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->purchaseAbonementLiteViewModels = $this->listAllLiteActiveByUserAndDanceGroupIdAndDateOfAction(
            $user,
            $danceGroupId,
            $dateOfAction
        );
        return $jsonAnswerStatus;
    }

    public function listAllLiteActiveByUserAndDanceGroupIdAndDateOfAction(User $user, int $danceGroupId, DateTime $dateOfAction): array {

        $isAllAbonementsAllow = true;
        $abonementsAllowed = [];
        $danceGroup = null;
        if($danceGroupId != 0){
            ...
        }

        $purchaseAbonements = $this->purchaseAbonementRepository->listAllActiveByUserIdWithIncludeAbonement($user->getId(), $dateOfAction->format("Y-m-d H:i:s"));
        $purchaseAbonementLiteViewModels = [];//PurchaseAbonementLiteViewModel[]
        foreach($purchaseAbonements as $purchaseAbonement){
            //проверка для групп с не со всеми действительными абонементами
            if(!$isAllAbonementsAllow){
                $isAbonementAllow = false;
                foreach($abonementsAllowed as $abonementAllowed){
                    ...
                }
                if(!$isAbonementAllow)continue;
            }
            array_push($purchaseAbonementLiteViewModels, $this->toLiteViewModel($purchaseAbonement));
        }

        return $purchaseAbonementLiteViewModels;
    }

    public function listAllLiteByUserId(int $userId): JsonAnswerStatus {
        $user = $this->userRepository->findById($userId);
        if($user == null)return new JsonAnswerStatus("error", "user_not_found");

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->purchaseAbonementLiteViewModels = $this->listAllLitesByUser($user);
        return $jsonAnswerStatus;
    }

    /**
     * @return PurchaseAbonementLiteViewModel[]
     */
    public function listAllLitesByUser(User $user): array {

        $purchaseAbonements = $this->purchaseAbonementRepository->listAllByUserId($user->getId());
        $purchaseAbonementLiteViewModel = [];

        foreach($purchaseAbonements as $purchaseAbonement){
            array_push($purchaseAbonementLiteViewModel, $this->toLiteViewModel($purchaseAbonement));
        }
        return $purchaseAbonementLiteViewModel;
    }

    public function addByDTO(PurchaseAbonementNewDTO $purchaseAbonementNewDTO): JsonAnswerStatus {
        $user = $this->userRepository->findById($purchaseAbonementNewDTO->getUserId());
        if($user == null)return new JsonAnswerStatus("error", "user_not_found");

        $abonement = $this->abonementRepository->findById($purchaseAbonementNewDTO->getAbonementId());
        if($abonement == null)throw new AbonementNotFoundException();

        $dateOfBuy = new DateTime(date($purchaseAbonementNewDTO->getDateOfAddStr()));

        $purchaseAbonementFactory = new PurchaseAbonementFactory();
        $purchaseAbonement = $purchaseAbonementFactory->create(
            $user,
            $abonement,
            $purchaseAbonementNewDTO->getPrice(),
            $purchaseAbonementNewDTO->getCashless(),
            $purchaseAbonementNewDTO->getVisits(),
            $purchaseAbonementNewDTO->getDays(),
            $purchaseAbonementNewDTO->getComment(),
            $dateOfBuy
        );

        $this->purchaseAbonementRepository->save($purchaseAbonement, true);
        //тут нужно отметить визит, если был передан id группы
        if($purchaseAbonementNewDTO->getDanceGroupId() != 0){
            $danceGroup = $this->danceGroupRepository->findById($purchaseAbonementNewDTO->getDanceGroupId());
            if($danceGroup == null)throw new DanceGroupNotFoundException();
            if(!$this->visitFacade->add($user, $danceGroup, $purchaseAbonement, $purchaseAbonementNewDTO->getDateOfAddStr())){
                return new JsonAnswerStatus("error", "try_add_visit");
            }
        }

        return new JsonAnswerStatus("success", null);
    }

    public function updateByDTO(PurchaseAbonementEditDTO $purchaseAbonementEditDTO): JsonAnswerStatus {

        $purchaseAbonement = $this->purchaseAbonementRepository->findById($purchaseAbonementEditDTO->getPurchaseAbonementId());
        if($purchaseAbonement == null)throw new PurchaseAbonementNotFoundException();

        $purchaseAbonement->setPrice($purchaseAbonementEditDTO->getPrice());
        $purchaseAbonement->setCashless($purchaseAbonementEditDTO->getCashless());
        $purchaseAbonement->setVisitsStart($purchaseAbonementEditDTO->getVisitsStart());
        $purchaseAbonement->setVisitsLeft($purchaseAbonementEditDTO->getVisitsLeft());
        $purchaseAbonement->setDays($purchaseAbonementEditDTO->getDays());

        if($purchaseAbonementEditDTO->getDateOfBuy() != null){
            $purchaseAbonement->setDateOfBuy(new DateTime(date($purchaseAbonementEditDTO->getDateOfBuy())));
        } else {
            $purchaseAbonement->setDateOfBuy(null);
        }
        if($purchaseAbonementEditDTO->getDateOfActivation() != null){
            $purchaseAbonement->setDateOfActivation(new DateTime(date($purchaseAbonementEditDTO->getDateOfActivation())));
        } else {
            $purchaseAbonement->setDateOfActivation(null);
        }
        if($purchaseAbonementEditDTO->getDateOfMustBeUsedTo() != null){
            $purchaseAbonement->setDateOfMustBeUsedTo(new DateTime(date($purchaseAbonementEditDTO->getDateOfMustBeUsedTo())));
        } else {
            $purchaseAbonement->setDateOfMustBeUsedTo(null);
        }
        
        $this->purchaseAbonementRepository->save($purchaseAbonement, true);

        return new JsonAnswerStatus("success", null);
    }

    public function deleteByAdmin(int $purchaseAbonementId): JsonAnswerStatus {
        $purchaseAbonement = $this->purchaseAbonementRepository->findById($purchaseAbonementId);
        if($purchaseAbonement == null)return new JsonAnswerStatus("error", "purchase_abonement_not_found");

        $this->purchaseAbonementRepository->remove($purchaseAbonement, true);

        return new JsonAnswerStatus("success", null);
    }

    public function getForEditById(int $purchaseAbonementId): JsonAnswerStatus {
        $purchaseAbonement = $this->purchaseAbonementRepository->findById($purchaseAbonementId);
        if($purchaseAbonement == null)return new JsonAnswerStatus("error", "purchase_abonement_not_found");

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->purchaseAbonementLiteViewModel = $this->toLiteViewModel($purchaseAbonement);
        return $jsonAnswerStatus;
    }
    

    public function toLiteViewModel(PurchaseAbonement $purchaseAbonement, bool $isActiveForDanceGroup = true): PurchaseAbonementLiteViewModel {
        $user = $purchaseAbonement->getUser();
        $abonement = $purchaseAbonement->getAbonement();

        return new PurchaseAbonementLiteViewModel(
            $purchaseAbonement->getId(),
            ($user != null ? $user->getId() : 0),
            ($abonement != null ? $abonement->getId() : 0),
            ($abonement != null ? $this->abonementFacade->toLiteViewModel($abonement) : null),
            $purchaseAbonement->getSpecialStatus(),
            $purchaseAbonement->getPrice(),
            $purchaseAbonement->getCashless(),
            $purchaseAbonement->getVisitsStart(),
            $purchaseAbonement->getVisitsLeft(),
            $purchaseAbonement->getDays(),
            $isActiveForDanceGroup,
            $purchaseAbonement->getDateOfBuy(),
            $purchaseAbonement->getDateOfAdd(),
            $purchaseAbonement->getDateOfActivation(),
            $purchaseAbonement->getDateOfMustBeUsedTo()
        );
    }
}