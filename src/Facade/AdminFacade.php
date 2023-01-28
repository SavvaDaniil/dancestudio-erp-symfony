<?php

namespace App\Facade;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use DateTime;

use App\Entity\Admin;
use App\Repository\AdminRepository;
use App\DTO\Admin\AdminLoginDTO;
use App\DTO\Admin\AdminProfileDTO;
use App\Exception\Admin\AdminAlreadyExistsException;
use App\Middleware\AdminMiddleware;

use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\Admin\AdminProfileViewModel;

class AdminFacade {

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasherInterface,
        private AdminRepository $adminRepository,
        private JWTTokenManagerInterface $jwtManager
    ){

    }

    public function login(AdminLoginDTO $adminLoginDTO): JsonAnswerStatus {
        $admin = $this->adminRepository->findByUsername($adminLoginDTO->getUsername());
        if(empty($admin))return new JsonAnswerStatus("error", "wrong");
        if(!$this->userPasswordHasherInterface->isPasswordValid($admin, $adminLoginDTO->getPassword())){
            return new JsonAnswerStatus("error", "wrong");
        }

        $adminMiddleware = new AdminMiddleware();
        $jsonAnswerStatus = new JsonAnswerStatus("success");
        $jsonAnswerStatus->access_token = $adminMiddleware->generateJWT($admin);
        return $jsonAnswerStatus;
    }

    public function registration(AdminLoginDTO $adminLoginDTO): bool {
        if($this->adminRepository->findByUsername($adminLoginDTO->getUsername()) != null){
            return new AdminAlreadyExistsException();
        }

        $admin = (new Admin())
        ->setUsername($adminLoginDTO->getUsername())
        ->setActive(1)
        ->setLevel(0)
        ...

        $admin->setPassword($this->userPasswordHasherInterface->hashPassword($admin, $adminLoginDTO->getPassword()));

        $this->adminRepository->save($admin, true);

        return true;
    }


    public function getProfileByUsername(string $adminUsername): JsonAnswerStatus {
        $admin = $this -> adminRepository -> findByUsername($adminUsername);
        if(is_null($admin))return new JsonAnswerStatus("error", "not_found");
        $adminProfileViewModel = $this->getProfileViewModel($admin);
        $jsonAnswerStatus = new JsonAnswerStatus("success");
        $jsonAnswerStatus->adminProfileViewModel = $adminProfileViewModel;
        return $jsonAnswerStatus;
    }

    public function getById(int $adminId): ?Admin {
        $admin = $this -> adminRepository -> findById($adminId);
        if(is_null($admin))return null;
        return $admin;
    }

    public function getProfileById(int $adminId): JsonAnswerStatus {
        $admin = $this -> adminRepository -> findById($adminId);
        if(is_null($admin))return new JsonAnswerStatus("error", "not_found");
        $adminProfileViewModel = $this->getProfileViewModel($admin);
        $jsonAnswerStatus = new JsonAnswerStatus("success");
        $jsonAnswerStatus->adminProfileViewModel = $adminProfileViewModel;
        return $jsonAnswerStatus;
    }

    public function getProfileViewModel(Admin $admin): AdminProfileViewModel {
        return new AdminProfileViewModel(
            $admin->getId(),
            $admin->getUsername(),
            $admin->getFirstname()
        );
    }

    public function profileUpdateBySelf(int $adminId, AdminProfileDTO $adminProfileDTO): JsonAnswerStatus {
        $admin = $this -> adminRepository -> findById($adminId);
        if(is_null($admin))return new JsonAnswerStatus("error", "not_found");
        //if($admin->getId() != $adminProfileDTO->getId())return new JsonAnswerStatus("error", "wrong_id");

        $isNeedRelogin = false;
        if($admin->getUsername() != $adminProfileDTO -> getUsername()){
            $adminAlreadyExist = $this -> adminRepository -> findByUsernameExceptId($adminProfileDTO->getUsername(), $admin->getId());
            if(!is_null($adminAlreadyExist))return new JsonAnswerStatus("error", "username_already_exist");
            $admin -> setUsername($adminProfileDTO->getUsername());
            $isNeedRelogin = true;
        }

        if($adminProfileDTO->getPasswordNew() != null && $adminProfileDTO->getPasswordCurrent() != null){
            if(!$this->userPasswordHasherInterface->isPasswordValid($admin, $adminProfileDTO->getPasswordCurrent())){
                return new JsonAnswerStatus("error", "current_password_wrong");
            }
            $admin->setPassword($this->userPasswordHasherInterface->hashPassword($admin, $adminProfileDTO->getPasswordNew()));
            $isNeedRelogin = true;
        }

        $admin->setFirstname($adminProfileDTO->getFirstname());
        $dateOfUpdate = new DateTime(date("Y-m-d H:i:s"));
        $admin->setDateOfLastUpdateProfile($dateOfUpdate);
        $this->adminRepository->save($admin, true);
        
        $jsonAnswerStatus = new JsonAnswerStatus("success");
        if($isNeedRelogin){
            $jsonAnswerStatus->access_token = $this->jwtManager->create($admin);
        }

        return $jsonAnswerStatus;
    }


}