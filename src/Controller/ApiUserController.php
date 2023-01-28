<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Facade\UserFacade;
use App\DTO\User\UserLoginDTO;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ApiUserController extends AbstractController
{
    public function __construct(
        private UserFacade $userFacade,
        private TokenStorageInterface $tokenStorageInterface, 
        private JWTTokenManagerInterface $jwtManager
        ){

    }

    #[Route('/api/user', name: 'app_api_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiUserController.php',
        ]);
    }

    #[Route('/api/user/secret')]
    public function secret(): JsonResponse
    {
        //print("getToken: " . $this->tokenStorageInterface->getToken());
        //$decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());
        //var_dump($decodedJwtToken);
        //print($this->jwtManager->create($userFromDb) . "\n");//create jwt by self
        return $this->json([
            'message' => 'api user secret!',
            'path' => 'src/Controller/ApiUserController.php',
        ]);
    }

    #[Route('/api/user/login', name: 'api_user_login_check')]
    public function login(): JsonResponse
    {
        return $this->json([
            'message' => 'api_user_login',
            'path' => 'src/Controller/ApiUserController.php',
        ]);
    }

    #[Route('/api/user/registration')]
    public function registration(Request $request): JsonResponse
    {
        //if application/json
        $parameters = json_decode($request->getContent(), true);
        //print("parameters username: " . $parameters["username"]);

        //var_dump($userLoginDTO);
        //$userLoginDTO = new UserLoginDTO($request->get("username"), $request->get("password"));
        //var_dump($userLoginDTO);
        $this->userFacade->registration($parameters["username"], $parameters["password"]);

        return $this->json([
            'message' => 'api user registration',
            'path' => 'src/Controller/ApiUserController.php',
        ]);
    }

    #[Route('/api/user/profile/get', name: 'app_api_user_profile_get')]
    public function profileGet(): JsonResponse
    {
        return $this->json([
            'message' => 'user profile get',
            'path' => 'src/Controller/ApiUserController.php',
        ]);
    }
}
