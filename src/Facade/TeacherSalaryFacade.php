<?php

namespace App\Facade;

use App\DTO\TeacherSalary\TeacherSalaryEditDTO;
use App\DTO\TeacherSalary\TeacherSalaryInfoViewModel;
use App\DTO\TeacherSalary\TeacherSalaryLiteViewModel;
use App\DTO\TeacherSalary\TeacherSalarySearchDTO;
use App\Entity\DanceGroup;
use App\Entity\TeacherSalary;
use App\Factory\TeacherSalaryFactory;
use App\Repository\DanceGroupRepository;
use App\Repository\TeacherRateRepository;
use App\Repository\TeacherSalaryRepository;
use App\Repository\VisitRepository;
use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\TeacherSalary\TeacherSalaryMoreInfoViewModel;
use App\ViewModel\TeacherSalary\TeacherSalaryPrepareViewModel;
use App\ViewModel\TeacherSalary\TeacherSalarySearchPrepareViewModel;
use DateTime;

class TeacherSalaryFacade {

    public function __construct(
        private DanceGroupFacade $danceGroupFacade,
        private TeacherFacade $teacherFacade,
        private VisitFacade $visitFacade,
        private TeacherSalaryRepository $teacherSalaryRepository,
        private TeacherRateRepository $teacherRateRepository,
        private DanceGroupRepository $danceGroupRepository,
        private VisitRepository $visitRepository,
    ){

    }

    public function updateByDTO(TeacherSalaryEditDTO $teacherSalaryEditDTO): JsonAnswerStatus {

        $teacherSalary = $this->teacherSalaryRepository->findById($teacherSalaryEditDTO->getTeacherSalaryId());
        if($teacherSalary == null)return new JsonAnswerStatus("error", "not_found");

        if($teacherSalaryEditDTO->getName() == "price_fact"){
            $teacherSalary->setPriceFact($teacherSalaryEditDTO->getValue());
            ...
        } else if($teacherSalaryEditDTO->getName() == "is_changed_by_admin"){
            $teacherSalary->setPriceFact($teacherSalary->getPriceAuto());
           ...
        }

        $teacherSalary->setDateOfUpdate(new DateTime(date("Y-m-d H:i:s")));
        $this->teacherSalaryRepository->save($teacherSalary, true);

        return new JsonAnswerStatus("success", null);
    }

    public function getMoreInfoById(int $teacherSalaryId): JsonAnswerStatus {

        $teacherSalary = $this->teacherSalaryRepository->findById($teacherSalaryId);
        if($teacherSalary == null)return new JsonAnswerStatus("error", "not_found");

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->teacherSalaryMoreInfoViewModel = $this->getMoreInfo($teacherSalary);
        return $jsonAnswerStatus;
    }

    public function getMoreInfo(TeacherSalary $teacherSalary): TeacherSalaryMoreInfoViewModel {

        $visitsOfTeacherSalary = [];
        $visitLiteViewModelsOfTeacherSalary = [];
        if($teacherSalary->getDanceGroup() != null){
            $visitsOfTeacherSalary = $this->visitRepository->listAllByDanceGroupIdOnDateOfAction(
                $teacherSalary->getDanceGroup()->getId(),
                $teacherSalary->getDateOfAction()
            );
            $visitLiteViewModelsOfTeacherSalary = $this->visitFacade->toListLiteViewModels($visitsOfTeacherSalary);
        }

        return new TeacherSalaryMoreInfoViewModel(
            $this->toInfoViewModel($teacherSalary, $visitsOfTeacherSalary),
            $visitLiteViewModelsOfTeacherSalary
        );
    }

    public function searchLitesByDTO(TeacherSalarySearchDTO $teacherSalarySearchDTO): JsonAnswerStatus {

        $dateFrom = ($teacherSalarySearchDTO->getDateFrom() != null ? $teacherSalarySearchDTO->getDateFrom() : date("Y-m-d"));
        $dateTo = ($teacherSalarySearchDTO->getDateTo() != null ? $teacherSalarySearchDTO->getDateTo() : date("Y-m-d"));

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->teacherSalaryLiteViewModels = $this->searchLites(
            $dateFrom,
            $dateTo,
            $teacherSalarySearchDTO->getDanceGroupId(),
            $teacherSalarySearchDTO->getTeacherId()
        );
        return $jsonAnswerStatus;
    }

    /**
     * @return TeacherSalaryLiteViewModel[]
     */
    public function searchLites(string $dateFrom, string $dateTo, int $danceGroupId, int $teacherId): array {

        $teacherSalaries = $this->teacherSalaryRepository->search(
            new DateTime(date($dateFrom)),
            new DateTime(date($dateTo)),
            $danceGroupId,
            $teacherId
        );
        $teacherSalaryLiteViewModels = [];
        foreach($teacherSalaries as $teacherSalary){
            array_push($teacherSalaryLiteViewModels, $this->toLiteViewModel($teacherSalary));
        }

        return $teacherSalaryLiteViewModels;
    }

    public function getSearchPrepareViewModel(): JsonAnswerStatus {
        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->teacherSalarySearchPrepareViewModel = new TeacherSalarySearchPrepareViewModel(
            $this->danceGroupFacade->listAllMicro(),
            $this->teacherFacade->listAllMicro()
        );
        return $jsonAnswerStatus;
    }


    public function autoUpdateAllGroupsOnDateOfAction(?string $dateOfActionStr, bool $isDebug = false): void {
        $danceGroupsAll = $this->danceGroupRepository->listAllIncludeTeacher();
        $danceGroupsWithoutAnyVisitsOnDateOfAction = [];

        $visitsAllOnDateOfAction = $this->visitRepository->listAllOnDateOfActionIncludePurchaseAbonementAndDanceGroup(new DateTime(date($dateOfActionStr)));

        $teacherSalaryPrice = 0;
        foreach($danceGroupsAll as $danceGroup){
            if($isDebug)print("danceGroup id: ".$danceGroup->getId()." danceGroup name: " . $danceGroup->getName() . "\n");

            $teacher = $danceGroup->getTeacher();
            if($teacher == null){
                if($isDebug)print("danceGroup teacher IS NULL \n");
                continue;
            }
            $teacherSalaryPrice = 0;

            $visits = [];
            foreach($visitsAllOnDateOfAction as $visitOnDateOfAction){
                if($visitOnDateOfAction->getDanceGroup() == null){
                    if($isDebug)print("visitOnDateOfAction getDanceGroup IS NULL \n");
                    continue;
                }
                if($visitOnDateOfAction->getDanceGroup()->getId() != $danceGroup->getId()){
                    if($isDebug)print("visitOnDateOfAction getDanceGroup: ".$visitOnDateOfAction->getDanceGroup()->getId()." != danceGroup.id ".$danceGroup->getId()." \n");
                    continue;
                }
                array_push($visits, $visitOnDateOfAction);
            }
            $visitsCount = count($visits);
            if($isDebug)print("visitsCount: " . $visitsCount . "\n");

            if($visitsCount == 0){
                //нужно добавить группу в список для удаления записи о зарплате
                array_push($danceGroupsWithoutAnyVisitsOnDateOfAction, $danceGroup);
                continue;
            }



            if($teacher->getStavka() == 0){
                //обычная

                ...
            } else if($teacher->getStavka() == 1){
                //По процентам

                ...

            } else if($teacher->getStavka() == 2){
                //Количественная
                
               ...
            }

            if($teacher->getStavkaPlus() == 1){
                if($visitsCount > $teacher->getPlusAfterStudents()){
                    ...
                }
            }

            $teacherSalary = $this->teacherSalaryRepository->findByTeacherIdAndDanceGroupIdOnDateOfAction($teacher->getId(), $danceGroup->getId(), new DateTime(date($dateOfActionStr)));
            if($teacherSalary == null){
                
                ...
            }


            if($teacherSalary->getPriceAuto() != $teacherSalaryPrice){
                $teacherSalary->setDateOfUpdate(new DateTime(date("Y-m-d H:i:s")));
                $teacherSalary->setPriceAuto($teacherSalaryPrice);
                if($teacherSalary->getIsChangedByAdmin() == 0){
                    $teacherSalary->setPriceFact($teacherSalaryPrice);
                }
                $this->teacherSalaryRepository->save($teacherSalary, true);
            }
        }

        $teacherSalariesAllOnDatOfAction = $this->teacherSalaryRepository->listAllOnDateOfActionIncludeDanceGroup(new DateTime(date($dateOfActionStr)));

        foreach($danceGroupsWithoutAnyVisitsOnDateOfAction as $danceGroupWithoutAnyVisitsOnDateOfAction){
            foreach($teacherSalariesAllOnDatOfAction as $teacherSalary){
                if($teacherSalary->getDanceGroup() == null)continue;
                if($teacherSalary->getDanceGroup()->getId() == $danceGroupWithoutAnyVisitsOnDateOfAction->getId()){
                    $this->teacherSalaryRepository->remove($teacherSalary, true);
                }
            }
        }
    }

    public function deleteById(int $teacherSalaryId): JsonAnswerStatus {

        $teacherSalary = $this->teacherSalaryRepository->findById($teacherSalaryId);
        if($teacherSalary == null)return new JsonAnswerStatus("error", "not_found");

        $this->teacherSalaryRepository->remove($teacherSalary, true);

        return new JsonAnswerStatus("success", null);
    }


    private function toLiteViewModel(TeacherSalary $teacherSalary): TeacherSalaryLiteViewModel {

        $danceGroup = $teacherSalary->getDanceGroup();
        $teacher = $teacherSalary->getTeacher();
        $visitsCount = 0;
        if($danceGroup != null){
            $visitsCount = count($this->visitRepository->listAllByDanceGroupIdOnDateOfAction($danceGroup->getId(), $teacherSalary->getDateOfAction()));
        }

        return new TeacherSalaryLiteViewModel(
            $teacherSalary->getId(),
            $teacherSalary->getDateOfAction(),
            ($danceGroup != null ? $this->danceGroupFacade->toMicroViewModel($danceGroup) : null),
            ($teacher != null ? $this->teacherFacade->toMicroViewModel($teacher) : null),
            $visitsCount,
            ($teacherSalary->getIsChangedByAdmin() == 1 ? $teacherSalary->getPriceFact() : $teacherSalary->getPriceAuto()),
            $teacherSalary->getStatus()
        );
    }

    private function toInfoViewModel(TeacherSalary $teacherSalary, ?array $visits): TeacherSalaryInfoViewModel {

        $danceGroup = $teacherSalary->getDanceGroup();
        $teacher = $teacherSalary->getTeacher();
        $visitsCount = 0;
        if($danceGroup != null && $visits == null){
            ...
            $teacherSalary->getDateOfAction()));
        } else if($visits != null){
            $visitsCount = count($visits);
        }

        return new TeacherSalaryInfoViewModel(
            $teacherSalary->getId(),
            $teacherSalary->getDateOfAction(),
            ($danceGroup != null ? $this->danceGroupFacade->toMicroViewModel($danceGroup) : null),
            ($teacher != null ? $this->teacherFacade->toMicroViewModel($teacher) : null),
            $visitsCount,
            $teacherSalary->getPriceAuto(),
            $teacherSalary->getIsChangedByAdmin(),
            $teacherSalary->getPriceFact(),
            $teacherSalary->getStatus()
        );
    }

}