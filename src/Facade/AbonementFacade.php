<?php


namespace App\Facade;

use DateTime;

use App\DTO\Abonement\AbonementNewDTO;
use App\DTO\Abonement\AbonementEditByColumnDTO;
use App\DTO\Abonement\AbonementEditDTO;
//use App\Model\Abonement\AbonementSpecialStatus;
use App\Exception\Abonement\AbonementWrongSpecialStatusException;
use App\Exception\Abonement\AbonementNotFoundException;
use App\Entity\Abonement;
use App\Entity\DanceGroup;
use App\Entity\User;
use App\Repository\AbonementRepository;
use App\ViewModel\Abonement\AbonementForBuyViewModel;
use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\Abonement\AbonementInfoViewModel;
use App\ViewModel\Abonement\AbonementLiteViewModel;

class AbonementFacade {

    public function __construct(
        private AbonementRepository $abonementRepository,
    ){

    }


    public function getForBuy(int $abonementId): JsonAnswerStatus {
        $abonement = $this->abonementRepository->findById($abonementId);
        if($abonement == null)return new JsonAnswerStatus("error", "not_found");
        
        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->abonementForBuyViewModel = $this->toForBuyViewModel($abonement);
        return $jsonAnswerStatus;
    }


    /**
    * @return AbonementLiteViewModel[] Returns an array of AbonementLiteViewModel objects
    */
    public function listAllLiteActiveForUserAndDanceGroup(User $user, DanceGroup $danceGroup): array {

        $abonements = [];
        $abonementLiteViewModels = [];
        if($danceGroup->getIsAbonementsAllowAll() == 1){
            $abonements = $this->abonementRepository->listAllActive();
        } else {
            $abonements = $this->abonementRepository->listAllActiveConnectedToDanceGroup($danceGroup->getId());
        }

        //нужна еще проверка, если абонемент приватный, подключен ли он к пользователю
        

        foreach($abonements as $abonement){
            array_push($abonementLiteViewModels, $this->toLiteViewModel($abonement));
        }

        return $abonementLiteViewModels;
    }


    /**
    * @return AbonementLiteViewModel[] Returns an array of AbonementLiteViewModel objects
    */
    public function listAllLiteActive(): array {
        $abonements = $this->abonementRepository->listAllActive();
        $abonementLiteViewModels = [];
        foreach($abonements as $abonement){
            array_push($abonementLiteViewModels, $this->toLiteViewModel($abonement));
        }
        return $abonementLiteViewModels;
    }

    public function addByDTO(AbonementNewDTO $abonementNewDTO): JsonAnswerStatus {
        $abonementNew = $this->generateNewByDTO($abonementNewDTO);
        $this->abonementRepository->save($abonementNew, true);
        return new JsonAnswerStatus("success", null);
    }

    public function editByColumnDTO(AbonementEditByColumnDTO $abonementEditByColumnDTO): JsonAnswerStatus {
        $abonement = $this->abonementRepository->findById($abonementEditByColumnDTO->getAbonement_id());
        if($abonement == null)return new JsonAnswerStatus("error", "not_found");
        $abonement = $this->editByColumn($abonement, $abonementEditByColumnDTO->getName(), $abonementEditByColumnDTO->getValue());
        $abonement->setDateOfAdd(new DateTime(date("Y-m-d H:i:s")));
        $this->abonementRepository->save($abonement, true);
        return new JsonAnswerStatus("success", null);
    }

    public function update(AbonementEditDTO $abonementEditDTO): JsonAnswerStatus {
        $abonement = $this->abonementRepository->findById($abonementEditDTO->getAbonement_id());
        if($abonement == null)return new JsonAnswerStatus("error", "not_found");


        $abonement->setName($abonementEditDTO->getName());
        $abonement->setDays($abonementEditDTO->getDays());
        $abonement->setPrice($abonementEditDTO->getPrice());
        ...

        $abonement->setDateOfUpdate(new DateTime(date("Y-m-d H:i:s")));
        $this->abonementRepository->save($abonement, true);
        
        return new JsonAnswerStatus("success", null);
    }

    public function editByColumn(Abonement $abonement, string $columnName, string $value): Abonement {

        switch ($columnName)
        {
            case "name":
                $abonement->setName($value);
                break;
            case "days":
                $abonement->setDays(intval($value));
                break;
            
            ...
                break;
        }
        
        return $abonement;
    }

    public function generateNewByDTO(AbonementNewDTO $abonementNewDTO): Abonement {
        $this->checkSpecialStatusOrThrowException($abonementNewDTO->getSpecial_status());
        return $this->generateNew($abonementNewDTO->getSpecial_status(), $abonementNewDTO->getIs_trial());
    }

    public function generateNew(string $specialStatus, bool $isTrial): Abonement {
        $abonementNew = new Abonement();
        $abonementNew->setName("Default " . $specialStatus);
        $abonementNew->setPrice(0);
        $abonementNew->setStatusOfVisible(0);
        ...
    }

    private function checkSpecialStatusOrThrowException(string $specialStatus): void {
        if($specialStatus != "raz" && $specialStatus != "usual" && $specialStatus != "unlim"){
            throw new AbonementWrongSpecialStatusException();
        }
    }

    public function deleteById(int $abonementId): JsonAnswerStatus {
        $abonement = $this->abonementRepository->findById($abonementId);
        if($abonement == null)throw new AbonementNotFoundException();
        $this->abonementRepository->remove($abonement, true);
        return new JsonAnswerStatus("success");
    }



    /**
    * @return AbonementInfoViewModel[] Returns an array of AbonementInfoViewModel objects
    */
    public function listAll(): array {
        $abonements = $this->abonementRepository->listAll();
        $abonementInfoViewModel = [];
        foreach($abonements as $abonement){
            array_push(
                $abonementInfoViewModel, 
                new AbonementInfoViewModel(
                    $abonement->getId(),
                    $abonement->getName(),
                    $abonement->getSpecialStatus(),
                    $abonement->getDays(),
                    $abonement->getPrice(),
                    $abonement->getVisits(),
                    $abonement->getStatusOfVisible(),
                    $abonement->getStatusOfDeleted(),
                    $abonement->getStatusForApp(),
                    $abonement->getIsTrial(),
                    $abonement->getIsPrivate()
                )
            );
        }

        return $abonementInfoViewModel;
    }


    /**
    * @return AbonementLiteViewModel[] Returns an array of AbonementLiteViewModel objects
    */
    public function listAllLite(): array {
        $abonements = $this->abonementRepository->listAll();
        $abonementLiteViewModels = [];
        foreach($abonements as $abonement){
            array_push($abonementLiteViewModels, $this->toLiteViewModel($abonement));
        }
        return $abonementLiteViewModels;
    }


    public function toLiteViewModel(Abonement $abonement): AbonementLiteViewModel {
        return new AbonementLiteViewModel(
            $abonement->getId(),
            $abonement->getName(),
            $abonement->getSpecialStatus(),
            $abonement->getPrice()
        );
    }

    public function toForBuyViewModel(Abonement $abonement): AbonementForBuyViewModel {
        return new AbonementForBuyViewModel(
            $abonement->getId(),
            $abonement->getName(),
            $abonement->getSpecialStatus(),
            $abonement->getDays(),
            $abonement->getPrice(),
            $abonement->getVisits(),
            $abonement->getIsTrial()
        );
    }
}