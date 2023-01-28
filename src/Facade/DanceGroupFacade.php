<?php

namespace App\Facade;

use App\DTO\DanceGroup\DanceGroupEditDTO;
use App\DTO\DanceGroup\DanceGroupNewDTO;
use App\Entity\ConnectionAbonementToDanceGroup;
use App\Entity\DanceGroup;
use App\Exception\Branch\BranchNotFoundException;
use App\Exception\Teacher\TeacherNotFoundException;
use App\Repository\BranchRepository;
use App\Repository\DanceGroupDayOfWeekRepository;
use App\Repository\DanceGroupRepository;
use App\Repository\TeacherRepository;
use App\ViewModel\ConnectionAbonementToDanceGroup\ConnectionAbonementToDanceGroupLiteViewModel;
use App\ViewModel\DanceGroup\DanceGroupEditPreviewViewModel;
use App\ViewModel\DanceGroup\DanceGroupEditViewModel;
use App\ViewModel\DanceGroup\DanceGroupLessonViewModel;
use App\ViewModel\DanceGroup\DanceGroupMicroViewModel;
use App\ViewModel\DanceGroup\DanceGroupPreviewViewModel;
use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\Teacher\TeacherMicroViewModel;
use DateTime;

class DanceGroupFacade {

    public function __construct(
        private DanceGroupRepository $danceGroupRepository,
        private TeacherFacade $teacherFacade,
        private TeacherRepository $teacherRepository,
        private BranchFacade $branchFacade,
        private BranchRepository $branchRepository,
        private DanceGroupDayOfWeekFacade $danceGroupDayOfWeekFacade,
        private DanceGroupDayOfWeekRepository $danceGroupDayOfWeekRepository,
        private AbonementFacade $abonementFacade,
        private ConnectionAbonementToDanceGroupFacade $connectionAbonementToDanceGroupFacade
    ){

    }

    public function update(DanceGroupEditDTO $danceGroupEditDTO): JsonAnswerStatus {
        $danceGroup = $this->danceGroupRepository->findById($danceGroupEditDTO->getDance_group_id());
        if($danceGroup == null)return new JsonAnswerStatus("error", "not_found");

        $danceGroup->setName($danceGroupEditDTO->getName());
        $danceGroup->setDescription($danceGroupEditDTO->getDescription());
        $danceGroup->setStatus($danceGroupEditDTO->getStatus());
        ...
        
        if($danceGroupEditDTO->getTeacher_id() == 0){
            $danceGroup->setTeacher(null);
        } else if($danceGroup->getTeacher() == null || ($danceGroup->getTeacher() != null && $danceGroup->getTeacher()->getId() != $danceGroupEditDTO->getTeacher_id())){
            $teacher = $this->teacherRepository->findById($danceGroupEditDTO->getTeacher_id());
            if($teacher == null)throw new TeacherNotFoundException();
            $danceGroup->setTeacher($teacher);
        }

        if($danceGroupEditDTO->getBranch_id() == 0){
            $danceGroup->setBranch(null);
        } else if($danceGroup->getBranch() == null || ($danceGroup->getBranch() != null && $danceGroup->getBranch()->getId() != $danceGroupEditDTO->getBranch_id())){
            $branch = $this->branchRepository->findById($danceGroupEditDTO->getBranch_id());
            if($branch == null)throw new BranchNotFoundException();
            $danceGroup->setBranch($branch);
        }

        $this->danceGroupRepository->save($danceGroup, true);
        return new JsonAnswerStatus("success", null);
    }

    /**
     * @return DanceGroupLessonViewModel[]
     */
    public function listAllLikeScheduleByDate(string $dateOfDayStr): array {
        $dateOfDay = date($dateOfDayStr);

        $danceGroups = $this->danceGroupRepository->listAll();
        $danceGroupDayOfWeeks = $this->danceGroupDayOfWeekRepository->listAllActive();
        $danceGroupLessonViewModels = [];

        $danceGroupDayOfWeek = null;
        $teacher = null;
        foreach($danceGroups as $danceGroup){
            foreach($danceGroupDayOfWeeks as $danceGroupDayOfWeek){
                if($danceGroupDayOfWeek->getDanceGroup()->getId() == $danceGroup->getId() && $danceGroupDayOfWeek->getDayOfWeek() == date(".............", strtotime($dateOfDay))){
                    $teacher = $danceGroup->getTeacher();
                    ...
                }
            }

        }

        return $danceGroupLessonViewModels;
    }

    /**
     * @return DanceGroupMicroViewModel[]
     */
    public function listAllMicro(): array {
        $danceGroups = $this->danceGroupRepository->listAll();
        $danceGroupMicroViewModels = [];
        foreach($danceGroups as $danceGroup){
            array_push($danceGroupMicroViewModels, $this->toMicroViewModel($danceGroup));
        }
        return $danceGroupMicroViewModels;
    }

    public function getEditViewModelById(int $danceGroupId): JsonAnswerStatus {
        $danceGroup = $this->danceGroupRepository->findById($danceGroupId);
        if($danceGroup == null)return new JsonAnswerStatus("error", "not_found");
        //return $this->getEditViewModel($danceGroup);

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->danceGroupEditViewModel = $this->getEditViewModel($danceGroup);
        return $jsonAnswerStatus;
    }

    public function getEditViewModel(DanceGroup $danceGroup): DanceGroupEditViewModel {

        $teacherMicroViewModels = $this->teacherFacade->listAllMicro();
        $teacherId = $danceGroup->getTeacher() != null ? $danceGroup->getTeacher()->getId() : 0;

        $branchMicroViewModels = $this->branchFacade->listAllMicro();
        $branchId = $danceGroup->getBranch() != null ? $danceGroup->getBranch()->getId() : 0;

        $danceGroupDayOfWeekLiteViewModels = [];
        $danceGroupDayOfWeeks = $danceGroup->getDanceGroupDayOfWeeks();
        foreach($danceGroupDayOfWeeks as $danceGroupDayOfWeek){
            array_push($danceGroupDayOfWeekLiteViewModels, $this->danceGroupDayOfWeekFacade->toLiteViewModel($danceGroupDayOfWeek));
        }

        //ConnectionAbonementToDanceGroupLiteViewModel
        $connectionAbonementToDanceGroupLiteViewModels = $this->connectionAbonementToDanceGroupFacade->listLiteByDanceGroup($danceGroup);
        $abonementLiteViewModels = $this->abonementFacade->listAllLite();

        $danceGroupEditViewModel = new DanceGroupEditViewModel(
            $danceGroup->getId(),
            $danceGroup->getName(),
            $teacherId,
            ...
            $connectionAbonementToDanceGroupLiteViewModels,
            $abonementLiteViewModels
        );

        return $danceGroupEditViewModel;
    }


    /**
    * @return DanceGroupEditPreviewViewModel[]
    */
    public function listAllEditPreviews(): array {
        $danceGroups = $this->danceGroupRepository->listAll();
        $danceGroupEditPreviewViewModels = [];

        $teacher = null;
        foreach($danceGroups as $danceGroup){
            $teacher = $danceGroup->getTeacher();
            array_push($danceGroupEditPreviewViewModels, new DanceGroupEditPreviewViewModel(
                $danceGroup->getId(),
                $danceGroup->getName(),
                ($teacher != null ? $this->teacherFacade->toMicroViewModel($teacher) : null),
                $danceGroup->getStatus(),
                $danceGroup->getStatusForApp()
            ));
        }

        return $danceGroupEditPreviewViewModels;
    }

    public function add(DanceGroupNewDTO $danceGroupNewDTO): JsonAnswerStatus {
        $danceGroup = $this->generateNew($danceGroupNewDTO->getName());
        $this->danceGroupRepository->save($danceGroup, true);
        return new JsonAnswerStatus("success", null);
    }

    public function generateNew(string $name): DanceGroup {
        $danceGroup = new DanceGroup();
        $danceGroup->setName($name);
        $danceGroup->setStatus(0);
        $danceGroup->setStatusOfCreative(0);
        $danceGroup->setStatusForApp(0);
        $danceGroup->setIsAbonementsAllowAll(0);
        $danceGroup->setIsActiveReservation(0);
        $danceGroup->setIsEvent(0);
        
        $dateOfAdd = new DateTime(date("Y-m-d H:i:s"));
        $danceGroup->setDateOfAdd($dateOfAdd);
        $danceGroup->setDateOfUpdate($dateOfAdd);
        return $danceGroup;
    }

    public function delete(int $danceGroupId): JsonAnswerStatus {
        $danceGroup = $this->danceGroupRepository->findById($danceGroupId);
        if($danceGroup == null)return new JsonAnswerStatus("error", "not_found");

        $this->danceGroupRepository->remove($danceGroup, true);

        return new JsonAnswerStatus("success", null);
    }
    

    public function toPreviewViewModel(DanceGroup $danceGroup): DanceGroupPreviewViewModel {
        $danceGroupTeacher = $danceGroup->getTeacher();
        return new DanceGroupPreviewViewModel(
            $danceGroup->getId(),
            $danceGroup->getName(),
            ($danceGroupTeacher != null ? $this->teacherFacade->toMicroViewModel($danceGroupTeacher) : null)
        );
    }

    public function toMicroViewModel(DanceGroup $danceGroup): DanceGroupMicroViewModel {
        return new DanceGroupMicroViewModel(
            $danceGroup->getId(),
            $danceGroup->getName()
        );
    }

}