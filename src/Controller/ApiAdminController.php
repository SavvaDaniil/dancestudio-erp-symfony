<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
//use Symfony\Component\Security\Core\User\UserInterface;

use App\Facade\AdminFacade;
use App\Repository\AdminRepository;
use App\DTO\Admin\AdminLoginDTO;
use App\DTO\Admin\AdminProfileDTO;
use App\DTO\User\UserEditDTO;
use App\DTO\User\UserNewByAdminDTO;
use App\DTO\User\UserSearchDTO;
use App\Facade\UserFacade;
use App\ViewModel\JsonAnswerStatus;
use App\Factory\JsonResponseFactory;
use App\Middleware\AdminMiddleware;

class ApiAdminController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private AdminFacade $adminFacade,
        private UserFacade $userFacade,
        //private UserInterface $userInterface,
        private TokenStorageInterface $tokenStorageInterface, 
        private JWTTokenManagerInterface $jwtManager,
        private JsonResponseFactory $jsonResponseFactory,
        private AdminRepository $adminRepository
        ){

    }


    #[Route('/api/admin/secret')]
    public function secret(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        return $this->json([
            'message' => 'api admin secret!',
            'path' => 'src/Controller/ApiAdminController.php',
        ]);
    }

    #[Route('/api/admin/login', name: 'api_admin_login_check')]
    public function login(Request $request): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $username = $parameters["username"];
        $password = $parameters["password"];
        return $this->json($this->adminFacade->login(new AdminLoginDTO($username, $password)));
    }

    #[Route('/api/admin/profile/get')]
    public function profileGet(Request $request): JsonResponse
    {
        //$decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        //return $this->json($this->adminFacade->getProfileByUsername($decodedJwtToken["username"]));
        //return $this->jsonResponseFactory->create($this->adminFacade->getProfileById($adminId));
        
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));
        return $this->json($this->adminFacade->getProfileById($adminId));
    }

    
    #[Route('/api/admin/profile/update', methods:["PUT"])]
    public function profileUpdate(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $username = $parameters["username"];
        $firstname = $parameters["firstname"];
        $passwordNew = (array_key_exists("password_new", $parameters) ? $parameters["password_new"] : null);
        $passwordCurrent = (array_key_exists("password_current", $parameters) ? $parameters["password_current"] : null);
        $adminProfileDTO = new AdminProfileDTO($username, $firstname, $passwordNew, $passwordCurrent);

        //$decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        return $this->json($this->adminFacade->profileUpdateBySelf($adminId, $adminProfileDTO));
    }
    
    #[Route("/api/admin/user/add")]
    public function userAdd(Request $request) : JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $secondname = $parameters["secondname"];
        $firstname = $parameters["firstname"];
        $telephone = $parameters["telephone"];
        $comment = $parameters["comment"];

        return $this->json($this->userFacade->addByAdmin(new UserNewByAdminDTO($secondname, $firstname, $telephone, $comment)));
    }
    
    #[Route("/api/admin/user/search", methods: ["POST"])]
    public function userSearch(Request $request) : JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $page = (int)$parameters["page"];
        $queryString = $parameters["query_string"];
        $isNeedCount = $parameters["is_need_count"];

        return $this->json($this->userFacade->search(new UserSearchDTO($page, $queryString, $isNeedCount)));
    }
    
    #[Route("/api/admin/user/get_search_preview", methods: ["POST"])]
    public function userGetSearchPreview(Request $request) : JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];

        return $this->json($this->userFacade->getSearchPreviewById($userId));
    }
    
    #[Route("/api/admin/user/profile/get", methods: ["POST"])]
    public function userProfileGet(Request $request) : JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];

        return $this->json($this->userFacade->getProfile($userId));
    }
    
    #[Route("/api/admin/user/profile/update", methods: ["PUT"])]
    public function userProfileUpdate(Request $request) : JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];
        $username = $parameters["username"];
        $password = $parameters["password"];
        $secondname = $parameters["secondname"];
        $firstname = $parameters["firstname"];
        $patronymic = $parameters["patronymic"];
        $telephone = $parameters["telephone"];
        $gender = (int)$parameters["gender"];
        $birthday = $parameters["birthday"];
        $parent_fio = $parameters["parent_fio"];
        $parent_phone = $parameters["parent_phone"];
        $comment = $parameters["comment"];

        return $this->json($this->userFacade->updateByAdmin(new UserEditDTO(
            $userId,
            $username,
            $password,
            $secondname,
            $firstname,
            $patronymic,
            $telephone,
            $gender,
            $birthday,
            $parent_fio,
            $parent_phone,
            $comment
        )));
    }


}
