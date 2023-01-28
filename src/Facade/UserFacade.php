<?php

namespace App\Facade;

use App\DTO\User\UserEditDTO;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\DTO\User\UserLoginDTO;
use App\DTO\User\UserNewByAdminDTO;
use App\DTO\User\UserSearchDTO;
use App\Exception\User\UserAlreadyExistsException;
use App\ViewModel\JsonAnswerStatus;
use App\ViewModel\User\UserMicroViewModel;
use App\ViewModel\User\UserProfileViewModel;
use App\ViewModel\User\UserSearchPreviewViewModel;

class UserFacade {

    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasherInterface,
        private UserRepository $userRepository
    ){

    }

    public function updateByAdmin(UserEditDTO $userEditDTO): JsonAnswerStatus {
        $user = $this->userRepository->findById($userEditDTO->getUser_id());
        if($user == null)return new JsonAnswerStatus("error", "not_found");

        //$user->setUsername($userEditDTO->getUsername());
        if(!empty($userEditDTO->getPassword())){
            $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, $userEditDTO->getPassword()));
        }
        $user->setSecondname($userEditDTO->getSecondname());
        $user->setFirstname($userEditDTO->getFirstname());
        $user->setPatronymic($userEditDTO->getPatronymic());
        $user->setTelephone($userEditDTO->getTelephone());
        $user->setGender($userEditDTO->getGender());
        //$user->setBirthday($userEditDTO->getUsername());
        if(!empty($userEditDTO->getBirthday())){
            $user->setBirthday(new DateTime(date($userEditDTO->getBirthday())));
        } else {
            $user->setBirthday(null);
        }
        $user->setParentFio($userEditDTO->getParent_fio());
        $user->setParentPhone($userEditDTO->getParent_phone());
        $user->setComment($userEditDTO->getComment());

        $user->setDateOfLastUpdateProfile(new DateTime(date("Y-m-d H:i:s")));
        $this->userRepository->save($user, true);

        return new JsonAnswerStatus("success", null);
    }
    
    public function getProfile(int $userId): JsonAnswerStatus {
        $user = $this->userRepository->findById($userId);
        if($user == null)return new JsonAnswerStatus("error", "not_found");

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->userProfileViewModel = $this->toProfileViewModel($user);
        return $jsonAnswerStatus;
    }

    public function addByAdmin(UserNewByAdminDTO $userNewByAdminDTO): JsonAnswerStatus {
        $userFactory = new UserFactory();
        $userNew = $userFactory->createByAdmin(
            $userNewByAdminDTO->getSecondname(),
            $userNewByAdminDTO->getFirstname(),
            $userNewByAdminDTO->getTelephone(),
            $userNewByAdminDTO->getComment()
        );
        $this->userRepository->save($userNew, true);
        return new JsonAnswerStatus("success", null);
    }

    public function search(UserSearchDTO $userSearchDTO): JsonAnswerStatus {
        $users = $this->userRepository->search($userSearchDTO->getPage(), $userSearchDTO->getQuery_string());

        $userSearchPreviewViewModels = [];
        foreach($users as $userFromDB){
            array_push($userSearchPreviewViewModels, $this->toSearchPreviewViewModel($userFromDB));
        }

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->userSearchPreviewViewModels = $userSearchPreviewViewModels;

        if($userSearchDTO->getIs_need_count()){
            $jsonAnswerStatus->countUserSearchQuery = $this->userRepository->countByQuery($userSearchDTO->getQuery_string());
        }

        return $jsonAnswerStatus;
    }

    public function getSearchPreviewById(int $userId): JsonAnswerStatus {
        $user = $this->userRepository->findById($userId);
        if($user == null)return new JsonAnswerStatus("error", "not_found");

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->userSearchPreviewViewModel = $this->toSearchPreviewViewModel($user);
        return $jsonAnswerStatus;
    }

    public function registration(string $username, string $password): bool {
        if($this->userRepository->findByUsername($username) != null){
            return new UserAlreadyExistsException();
        }

        $user = (new User())
        ->setUsername($username)
        ...

        $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, $password));

        $this->userRepository->save($user, true);

        return true;
    }

    public function toMicroViewmodel(User $user): UserMicroViewModel {
        return new UserMicroViewModel(
            $user->getId(),
            $user->getUsername(),
            $user->getSecondname(),
            $user->getFirstname()
        );
    }

    private function toProfileViewModel(User $user): UserProfileViewModel {
        return new UserProfileViewModel(
            $user->getId(),
            $user->getUsername(),
            $user->getSecondname(),
            $user->getFirstname(),
            $user->getPatronymic(),
            $user->getTelephone(),
            $user->getGender(),
            ($user->getBirthday() != null ? $user->getBirthday()->format("Y-m-d") : null),
            $user->getParentFio(),
            $user->getParentPhone(),
            $user->getComment()
        );
    }

    private function toSearchPreviewViewModel(User $user) : UserSearchPreviewViewModel {
        return new UserSearchPreviewViewModel(
            $user->getId(),
            $user->getSecondname(),
            $user->getFirstname(),
            null,
            ($user->getDateOfAdd() != null ? $user->getDateOfAdd()->format("Y-m-d H:i:s") : null),
            $user->getTelephone(),
            null
        );
    }
}