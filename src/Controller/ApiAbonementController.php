<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Facade\AbonementFacade;
use App\Middleware\AdminMiddleware;
use App\DTO\Abonement\AbonementNewDTO;
use App\DTO\Abonement\AbonementEditDTO;
use App\ViewModel\JsonAnswerStatus;

class ApiAbonementController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private AbonementFacade $abonementFacade,
        ){

    }

    #[Route('/api/abonement/get_for_buy', methods:["POST"])]
    public function getForBuy(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));
        
        $parameters = json_decode($request->getContent(), true);
        $abonementId = $parameters["abonement_id"];
        return $this->json($this->abonementFacade->getForBuy($abonementId));
    }

    #[Route('/api/abonement/list_all_lite_active', methods:["GET"])]
    public function listAllLiteActive(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));
        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->abonementLiteViewModels = $this->abonementFacade->listAllLiteActive();

        return $this->json($jsonAnswerStatus);
    }

    #[Route('/api/abonement', name: 'app_api_abonement')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'api adonement index',
            'path' => 'src/Controller/ApiAbonementController.php',
        ]);
    }


    #[Route('/api/abonement/add')]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $special_status = $parameters["special_status"];
        $is_trial = $parameters["is_trial"];
        
        return $this->json($this->abonementFacade->addByDTO(new AbonementNewDTO($special_status, $is_trial)));
    }

    #[Route('/api/abonement/delete')]
    public function delete(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $abonementId = $parameters["abonement_id"];
        return $this->json($this->abonementFacade->deleteById($abonementId));
    }

    #[Route('/api/abonement/list_all')]
    public function listAll(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));
        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->abonementInfoViewModels = $this->abonementFacade->listAll();

        return $this->json($jsonAnswerStatus);
    }

    
    #[Route('/api/abonement/update', methods:["PUT"])]
    public function profileUpdate(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $abonement_id = (int)$parameters["abonement_id"];
        $name = $parameters["name"];
        $days = (int)$parameters["days"];
        $price = (int)$parameters["price"];
        $visits = (int)$parameters["visits"];
        $status_of_visible = (int)$parameters["status_of_visible"];
        $status_for_app = (int)$parameters["status_for_app"];
        $is_private = (int)$parameters["is_private"];

        $abonementEditDTO = new AbonementEditDTO(
            $abonement_id,
            $name,
            $days,
            $price,
            $visits,
            $status_of_visible,
            $status_for_app,
            $is_private
        );
        //$adminProfileDTO = new AdminProfileDTO($username, $firstname, $passwordNew, $passwordCurrent);

        //$decodedJwtToken = $this->jwtManager->decode($this->tokenStorageInterface->getToken());

        return $this->json($this->abonementFacade->update($abonementEditDTO));
    }

}
