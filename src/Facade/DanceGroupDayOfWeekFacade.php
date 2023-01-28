<?php


namespace App\Facade;

use App\DTO\DanceGroup\DanceGroupNewDTO;
use App\DTO\DanceGroupDayOfWeek\DanceGroupDayOfWeekNewDTO;
use App\DTO\DanceGroupDayOfWeek\DanceGroupDayOfWeekPatchDTO;
use App\Entity\DanceGroup;
use App\Entity\DanceGroupDayOfWeek;
use App\Repository\DanceGroupDayOfWeekRepository;
use App\Repository\DanceGroupRepository;
use App\ViewModel\DanceGroupDayOfWeek\DanceGroupDayOfWeekLiteViewModel;
use App\ViewModel\JsonAnswerStatus;
use DateTime;

class DanceGroupDayOfWeekFacade {

    public function __construct(
        private DanceGroupDayOfWeekRepository $danceGroupDayOfWeekRepository,
        private DanceGroupRepository $danceGroupRepository
    ){

    }

    public function patch(DanceGroupDayOfWeekPatchDTO $danceGroupDayOfWeekPatchDTO): JsonAnswerStatus {
        $danceGroupDayOfWeek = $this->danceGroupDayOfWeekRepository->findById($danceGroupDayOfWeekPatchDTO->getDance_group_day_of_week_id());
        if($danceGroupDayOfWeek == null)return new JsonAnswerStatus("error", "not_found");

        switch($danceGroupDayOfWeekPatchDTO->getName()){
            case "day_of_week":
                $danceGroupDayOfWeek->setDayOfWeek((int)$danceGroupDayOfWeekPatchDTO->getValue());
                break;
            case "time_from":
                $danceGroupDayOfWeek->setTimeFrom(new DateTime(date($danceGroupDayOfWeekPatchDTO->getValue())));
                break;
            ...
            default:
                break;
        }
        $danceGroupDayOfWeek->setDateOfUpdate(new DateTime(date("Y-m-d H:i:s")));
        $this->danceGroupDayOfWeekRepository->save($danceGroupDayOfWeek, true);
        return new JsonAnswerStatus("success", null);
    }

    public function add(DanceGroupDayOfWeekNewDTO $danceGroupDayOfWeekNewDTO): JsonAnswerStatus {
        $danceGroup = $this->danceGroupRepository->findById($danceGroupDayOfWeekNewDTO->getDance_group_id());
        if($danceGroup == null)return new JsonAnswerStatus("error", "not_found");
        $danceGroupDayOfWeek = $this->generateNew($danceGroup, $danceGroupDayOfWeekNewDTO->getIs_event());

        $this->danceGroupDayOfWeekRepository->save($danceGroupDayOfWeek, true);
        return new JsonAnswerStatus("success", null);
    }

    public function delete(int $danceGroupDayOfWeekId): JsonAnswerStatus {
        $danceGroupDayOfWeek = $this->danceGroupDayOfWeekRepository->findById($danceGroupDayOfWeekId);
        if($danceGroupDayOfWeek == null)return new JsonAnswerStatus("error", "not_found");
        $this->danceGroupDayOfWeekRepository->remove($danceGroupDayOfWeek, true);
        return new JsonAnswerStatus("success", null);
    }

    public function generateNew(DanceGroup $danceGroup, bool $isEvent): DanceGroupDayOfWeek {
        $danceGroupDayOfWeek = new DanceGroupDayOfWeek();
        $danceGroupDayOfWeek->setDanceGroup($danceGroup);
        $danceGroupDayOfWeek->setDayOfWeek(0);
        ...
        $danceGroupDayOfWeek->setDateOfAdd($dateOfAdd);
        $danceGroupDayOfWeek->setDateOfUpdate($dateOfAdd);
        return $danceGroupDayOfWeek;
    }

    public function toLiteViewModel(DanceGroupDayOfWeek $danceGroupDayOfWeek): DanceGroupDayOfWeekLiteViewModel {
        $danceGroup = $danceGroupDayOfWeek->getDanceGroup();
        return new DanceGroupDayOfWeekLiteViewModel(
            $danceGroupDayOfWeek->getId(),
            ($danceGroup != null ? $danceGroup->getId() : 0),
            $danceGroupDayOfWeek->getDayOfWeek(),
            $danceGroupDayOfWeek->getStatus(),
            ($danceGroupDayOfWeek->getTimeFrom() != null ? $danceGroupDayOfWeek->getTimeFrom()->format("H:i") : null),
            ($danceGroupDayOfWeek->getTimeTo() != null ? $danceGroupDayOfWeek->getTimeTo()->format("H:i") : null),
            $danceGroupDayOfWeek->getIsEvent(),
            ($danceGroupDayOfWeek->getDateOfEvent() != null ? $danceGroupDayOfWeek->getDateOfEvent()->format("Y-m-d") : null)
        );
    }
}