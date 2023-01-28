<?php

namespace App\Facade;

use App\DTO\Branch\BranchEditDTO;
use App\DTO\Branch\BranchNewDTO;
use DateTime;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

use App\Entity\Branch;
use App\Repository\BranchRepository;
use App\ViewModel\Branch\BranchInfoViewModel;
use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\Branch\BranchLiteViewModel;
use App\ViewModel\Branch\BranchMicroViewModel;

class BranchFacade {

    public function __construct(
        private BranchRepository $branchRepository,
    ){

    }

    
    public function getFullInfo(int $branchId): JsonAnswerStatus {
        $branch = $this->branchRepository->findById($branchId);
        ...
        return $jsonAnswerStatus;
    }

    public function add(BranchNewDTO $branchNewDTO): JsonAnswerStatus {
        $branch = $this->generateNew($branchNewDTO->getName(), $branchNewDTO->getCoordinates(), $branchNewDTO->getDescription());
        $this->branchRepository->save($branch, true);
        return new JsonAnswerStatus("success", null);
    }

    public function delete(int $branchId): JsonAnswerStatus {
        $branch = $this->branchRepository->findById($branchId);
        if($branch == null)return new JsonAnswerStatus("error", "not_found");

        $this->branchRepository->remove($branch, true);

        return new JsonAnswerStatus("success", null);
    }

    /**
    * @return BranchLiteViewModel[]
    */
    public function listAllLites(): array {
        $branchs = $this->branchRepository->listAll();
        $branchLiteViewModels = [];

        foreach($branchs as $branch){
            ...
        }

        return $branchLiteViewModels;
    }

    /**
    * @return BranchMicroViewModel[]
    */
    public function listAllMicro(): array {
        $branchs = $this->branchRepository->listAll();
        $branchMicroViewModels = [];

        foreach($branchs as $branch){
            array_push($branchMicroViewModels, new BranchMicroViewModel(
                $branch->getId(),
                $branch->getName()
            ));
        }

        return $branchMicroViewModels;
    }

    
    public function update(BranchEditDTO $branchEditDTO): JsonAnswerStatus {
        $branch = $this->branchRepository->findById($branchEditDTO->getBranch_id());
        if($branch == null)return new JsonAnswerStatus("error", "not_found");

        $branch->setName($branchEditDTO->getName());
        $branch->setCoordinates($branchEditDTO->getCoordinates());
        $branch->setDescription($branchEditDTO->getDescription());
        
        $branch->setDateOfUpdate(new DateTime(date("Y-m-d H:i:s")));

        $this->branchRepository->save($branch, true);
        return new JsonAnswerStatus("success", null);
    }
    


    public function generateNew(string $name, ?string $coordinates, ?string $description): Branch {
        $dateOfAdd = new DateTime(date("Y-m-d H:i:s"));
        $branchNew = new Branch();
        $branchNew->setName($name);
        $branchNew->setCoordinates($coordinates);
        $branchNew->setDescription($description);
        $branchNew->setDateOfAdd($dateOfAdd);
        $branchNew->setDateOfUpdate($dateOfAdd);
        return $branchNew;
    }

    
    public function toInfoViewModel(Branch $branch, bool $isWithRates = false): BranchInfoViewModel {
        $branchInfoViewModel = new BranchInfoViewModel(
            $branch->getId(),
            $branch->getName(),
            $branch->getCoordinates(),
            $branch->getDescription()
        );
        return $branchInfoViewModel;
    }

    public function toMicroViewModel(Branch $branch): BranchMicroViewModel {
        $branchMicroViewModel = new BranchMicroViewModel(
            $branch->getId(),
            $branch->getName()
        );
        return $branchMicroViewModel;
    }
    

}