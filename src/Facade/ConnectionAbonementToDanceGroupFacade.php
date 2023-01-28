<?php

namespace App\Facade;

use App\DTO\ConnectionAbonementToDanceGroup\ConnectionAbonementToDanceGroupEditDTO;
use App\Entity\Abonement;
use App\Entity\ConnectionAbonementToDanceGroup;
use App\Entity\DanceGroup;
use App\Exception\Abonement\AbonementNotFoundException;
use App\Exception\DanceGroup\DanceGroupNotFoundException;
use App\Repository\AbonementRepository;
use App\Repository\ConnectionAbonementToDanceGroupRepository;
use App\Repository\DanceGroupRepository;
use App\ViewModel\ConnectionAbonementToDanceGroup\ConnectionAbonementToDanceGroupLiteViewModel;
use App\ViewModel\JsonAnswerStatus;
use DateTime;

class ConnectionAbonementToDanceGroupFacade {

    public function __construct(
        private DanceGroupRepository $danceGroupRepository,
        private AbonementRepository $abonementRepository,
        private ConnectionAbonementToDanceGroupRepository $connectionAbonementToDanceGroupRepository
    )
    {
        
    }

    public function listLiteByDanceGroup(DanceGroup $danceGroup): array {
        $connectionAbonementToDanceGroups = $danceGroup->getConnectionAbonementToDanceGroups();
        $connectionAbonementToDanceGroupLiteViewModels = [];
        foreach($connectionAbonementToDanceGroups as $connectionAbonementToDanceGroup){
            array_push($connectionAbonementToDanceGroupLiteViewModels, new ConnectionAbonementToDanceGroupLiteViewModel(
                $connectionAbonementToDanceGroup->getId(),
                ($connectionAbonementToDanceGroup->getAbonement() != null ? $connectionAbonementToDanceGroup->getAbonement()->getId() : 0),
                $danceGroup->getId()
            ));
        }
        return $connectionAbonementToDanceGroupLiteViewModels;
    }

    public function update(ConnectionAbonementToDanceGroupEditDTO $connectionAbonementToDanceGroupEditDTO): JsonAnswerStatus {
       
        $danceGroup = $this->danceGroupRepository->findById($connectionAbonementToDanceGroupEditDTO->getDance_group_id());
        if($danceGroup == null)throw new DanceGroupNotFoundException();
        $connectionAbonementToDanceGroups = $danceGroup->getConnectionAbonementToDanceGroups();
        $connectionAbonementToDanceGroup = null;
        foreach($connectionAbonementToDanceGroups as $connectionAbonementToDanceGroupFromDB){
            if($connectionAbonementToDanceGroupFromDB->getAbonement()->getId() == $connectionAbonementToDanceGroupEditDTO->getAbonement_id()){
                $connectionAbonementToDanceGroup = $connectionAbonementToDanceGroupFromDB;
                ...
            }
        }

        if($connectionAbonementToDanceGroupEditDTO->getValue() == 0){
            if($connectionAbonementToDanceGroup != null){
                $this->connectionAbonementToDanceGroupRepository->remove($connectionAbonementToDanceGroup, true);
            }
        } else if($connectionAbonementToDanceGroupEditDTO->getValue() == 1){
            if($connectionAbonementToDanceGroup == null){
                $abonement = $this->abonementRepository->findById($connectionAbonementToDanceGroupEditDTO->getAbonement_id());
                ...
                $this->connectionAbonementToDanceGroupRepository->save($connectionAbonementToDanceGroup, true);
            }
        }
        return new JsonAnswerStatus("success", null);
    }

    public function generateNew(Abonement $abonement, DanceGroup $danceGroup): ConnectionAbonementToDanceGroup {
        $connectionAbonementToDanceGroup = new ConnectionAbonementToDanceGroup();
        $connectionAbonementToDanceGroup->setAbonement($abonement);
        $connectionAbonementToDanceGroup->setDanceGroup($danceGroup);
        $connectionAbonementToDanceGroup->setDateOfAdd(new DateTime(date("Y-m-d H:i:s")));
        return $connectionAbonementToDanceGroup;
    }

}