<?php

namespace App\Facade;

use DateTime;
use App\DTO\TeacherRate\TeacherRateNewDTO;
use App\DTO\TeacherRate\TeacherRateEditDTO;
use App\Entity\Teacher;
use App\Entity\TeacherRate;
use App\Repository\TeacherRateRepository;
use App\Repository\TeacherRepository;
use App\Exception\Teacher\TeacherNotFoundException;
use App\Exception\TeacherRate\TeacherRateNotFoundException;
use App\Exception\TeacherRate\TeacherRateUnknownColumnNameForEditException;

use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\TeacherRate\TeacherRateLiteViewModel;

class TeacherRateFacade {

    public function __construct(
        private TeacherRateRepository $teacherRateRepository,
        private TeacherRepository $teacherRepository){

    }

    public function add(int $teacherId): JsonAnswerStatus {
        $teacher = $this->teacherRepository->findById($teacherId);
        if($teacher == null)throw new TeacherNotFoundException();
        $teacherRate = $this->generateNew($teacher);
        $this->teacherRateRepository->save($teacherRate, true);
        return new JsonAnswerStatus("success");
    }

    public function deleteById(int $teacherRateId): JsonAnswerStatus {
        $teacherRate = $this->teacherRateRepository->findById($teacherRateId);
        if($teacherRate == null)throw new TeacherRateNotFoundException();
        $this->teacherRateRepository->remove($teacherRate, true);
        return new JsonAnswerStatus("success");
    }

    public function update(TeacherRateEditDTO $teacherRateEditDTO): JsonAnswerStatus {
        $teacherRate = $this->teacherRateRepository->findById($teacherRateEditDTO->getTeacher_rate_id());
        if($teacherRate == null)throw new TeacherRateNotFoundException();
        switch($teacherRateEditDTO->getName()){
            case "students":
                $teacherRate->setStudents($teacherRateEditDTO->getValue());
                break;
            case "price":
                $teacherRate->setPrice($teacherRateEditDTO->getValue());
                break;
            default:
                throw new TeacherRateUnknownColumnNameForEditException();
                break;
        }
        $teacherRate->setDateOfUpdate(new DateTime(date("Y-m-d H:i:s")));
        $this->teacherRateRepository->save($teacherRate, true);
        
        return new JsonAnswerStatus("success");
    }


    public function generateNew(Teacher $teacher){
        $teacherRate = new TeacherRate();
        ...

        return $teacherRate;
    }


    public function listLitesByTeacher(Teacher $teacher): array {
        $teacherRates = $teacher->getTeacherRates();
        $teacherInfoViewModels = [];

        foreach($teacherRates as $teacherRate){
            array_push(
                $teacherInfoViewModels, 
                new TeacherRateLiteViewModel(
                    $teacherRate->getId(),
                    $teacherRate->getStudents(),
                    $teacherRate->getPrice()
                )
            );
        }

        usort($teacherInfoViewModels, function($a, $b){return strcmp($a->students, $b->students);});

        return $teacherInfoViewModels;
    }

}