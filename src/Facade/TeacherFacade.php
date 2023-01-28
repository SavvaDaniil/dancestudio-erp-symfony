<?php

namespace App\Facade;

use DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use App\DTO\Teacher\TeacherNewDTO;
use App\DTO\Teacher\TeacherEditByColumnDTO;
use App\DTO\Teacher\TeacherEditDTO;
use App\Entity\Teacher;
use App\Repository\TeacherRepository;

use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\Teacher\TeacherInfoViewModel;
use App\ViewModel\Teacher\TeacherMicroViewModel;
use TeacherLiteViewModel;

class TeacherFacade {

    public function __construct(
        private TeacherRepository $teacherRepository,
        private TeacherRateFacade $teacherRateFacade
    ){

    }

    public function getFullInfo(int $teacherId): JsonAnswerStatus {
        $teacher = $this->teacherRepository->findById($teacherId);
        if($teacher == null)return new JsonAnswerStatus("error", "not_found");
        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->teacherInfoViewModel = $this->toInfoViewModel($teacher, true);
        return $jsonAnswerStatus;
    }


    public function add(TeacherNewDTO $teacherNewDTO): JsonAnswerStatus {
        $teacher = $this->generateNew($teacherNewDTO->getName());
        $teacher->setDateOfAdd(new DateTime(date("Y-m-d H:i:s")));
        $teacher->setDateOfUpdate(new DateTime(date("Y-m-d H:i:s")));
        $this->teacherRepository->save($teacher, true);
        return new JsonAnswerStatus("success", null);
    }

    public function delete(int $teacherId): JsonAnswerStatus {
        $teacher = $this->teacherRepository->findById($teacherId);
        if($teacher == null)return new JsonAnswerStatus("error", "not_found");

        $this->posterDelete($teacher);
        $this->teacherRepository->remove($teacher, true);

        return new JsonAnswerStatus("success", null);
    }

    /**
    * @return TeacherMicroViewModel[]
    */
    public function listAllMicro(): array {
        $teachers = $this->teacherRepository->listAll();
        $teacherMicroViewModels = [];
        foreach($teachers as $teacher){
            array_push($teacherMicroViewModels, $this->toMicroViewModel($teacher));
        }
        return $teacherMicroViewModels;
    }

    /**
    * @return TeacherLiteViewModel[]
    */
    public function listAllLites(): array {
        $teachers = $this->teacherRepository->listAll();
        $teacherLiteViewModels = [];

        foreach($teachers as $teacher){
            array_push($teacherLiteViewModels, new TeacherLiteViewModel(
                $teacher->getId(),
                $teacher->getName(),
                (count($teacher->getDanceGroups()) > 0)
            ));
        }

        return $teacherLiteViewModels;
    }

    public function update(TeacherEditDTO $teacherEditDTO): JsonAnswerStatus {
        $teacher = $this->teacherRepository->findById($teacherEditDTO->getTeacher_id());
        if($teacher == null)return new JsonAnswerStatus("error", "not_found");

        $teacher->setName($teacherEditDTO->getName());
        $teacher->setStavka(intval($teacherEditDTO->getStavka()));
        $teacher->setMinStudents(intval($teacherEditDTO->getMin_students()));
        ...

        $this->teacherRepository->save($teacher, true);
        return new JsonAnswerStatus("success", null);
    }

    public function updateByColumn(TeacherEditByColumnDTO $teacherEditByColumnDTO): JsonAnswerStatus {
        $teacher = $this->teacherRepository->findById($teacherEditByColumnDTO->getTeacher_id());
        if($teacher == null)return new JsonAnswerStatus("error", "not_found");

        if($teacherEditByColumnDTO->getName() == "posterUpload"){

        } else if($teacherEditByColumnDTO->getName() == "posterDelete"){

        } else {
            $teacher = $this->editByColumn($teacher, $teacherEditByColumnDTO->getName(), $teacherEditByColumnDTO->getValue());
            $this->teacherRepository->save($teacher, true);
        }
        return new JsonAnswerStatus("success", null);
    }

    public function editByColumn(Teacher $teacher, string $columnName, string $value): Teacher {

        switch ($columnName)
        {
            case "name":
                $teacher->setName($value);
                break;
            case "stavka":
                $teacher->setStavka(intval($value));
                break;
            case "min_students":
                $teacher->setMinStudents(intval($value));
                break;
            ...
            case "procent":
                $procent = intval($value);
                $procent = ($procent > 100 || $procent < 0 ? 0 : $procent);
                $teacher->setProcent(intval($procent));
                break;
            default:
                break;
        }
        
        return $teacher;
    }

    public function posterUpload(int $teacherId, UploadedFile $posterFile): JsonAnswerStatus {
        $teacher = $this->teacherRepository->findById($teacherId);
        if($teacher == null)return new JsonAnswerStatus("error", "not_found");

        if($posterFile->getSize() > 1000000 * 10)return new JsonAnswerStatus("error", "too_big_size");

        try {
            ...
        } catch (FileException $e){
            //$this->logger->error('failed to upload image: ' . $e->getMessage());
            throw new FileException('Failed to upload file: ' . $e->getMessage());
        }

        return new JsonAnswerStatus("success");
    }

    public function posterDeleteByTeacherId(int $teacherId): JsonAnswerStatus {
        ...

        return new JsonAnswerStatus("success");
    }

    public function posterDelete(Teacher $teacher): bool {
        $pathToFile = $this->getPosterPath($teacher);
        if(file_exists($pathToFile)){
            return unlink($pathToFile);
        }
        return false;
    }

    public function generateNew(string $name): Teacher {
        $teacherNew = new Teacher();
        $teacherNew->setName($name);
        $teacherNew->setStavka(0);
        $teacherNew->setMinStudents(0);
        ...
        return $teacherNew;
    }

    public function getPosterPath(Teacher $teacher): string {
        return "XXXXXXXXXXXXXXXXXXXXXXXXXXX/" . $teacher->getId() . ".jpg";
    }

    public function getPosterSrc(Teacher $teacher): ?string {
        $pathToFile = $this->getPosterPath($teacher);
        return file_exists($pathToFile) ? $pathToFile : null;
    }

    public function toInfoViewModel(Teacher $teacher, bool $isWithRates = false): TeacherInfoViewModel {
        $teacherInfoViewModel = new TeacherInfoViewModel(
            $teacher->getId(),
            $teacher->getName(),
            $this->getPosterSrc($teacher),
            $teacher->getStavka(),
            $teacher->getMinStudents(),
            $teacher->getRaz(),
            $teacher->getUsual(),
            $teacher->getUnlim(),
            $teacher->getStavkaPlus(),
            $teacher->getPlusAfterStudents(),
            $teacher->getPlusAfterSumma(),
            $teacher->getProcent()
        );

        if($isWithRates)$teacherInfoViewModel->setTeacherRateLiteViewModels(
            $this->teacherRateFacade->listLitesByTeacher($teacher)
        );

        return $teacherInfoViewModel;
    }

    public function toMicroViewModel(Teacher $teacher): TeacherMicroViewModel {
        return new TeacherMicroViewModel($teacher->getId(), $teacher->getName());
    }
}