<?php

namespace App\Controller;

use App\DTO\Visit\VisitNewDTO;
use App\DTO\Visit\VisitPrepareDTO;
use App\Facade\VisitFacade;
use App\Middleware\AdminMiddleware;
use App\ViewModel\JsonAnswerStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiVisitController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private VisitFacade $visitFacade,
        ){

    }

    #[Route('/api/visit/add', methods:["PUT"])]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];
        $danceGroupId = (int)$parameters["dance_group_id"];
        $purchaseAbonementId = (int)$parameters["purchase_abonement_id"];
        $dateOfAction = $parameters["date_of_action"];
        
        return $this->json($this->visitFacade->addByAdmin(
            new VisitNewDTO(
                $userId,
                $danceGroupId,
                $purchaseAbonementId,
                $dateOfAction
            )
        ));
    }

    #[Route('/api/visit/prepare')]
    public function prepare(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];
        $danceGroupId = (array_key_exists("dance_group_id", $parameters) ? (int)$parameters["dance_group_id"] : 0);
        $date_of_action = $parameters["date_of_action"];
        
        return $this->json($this->visitFacade->prepareForUserByAdmin(
            new VisitPrepareDTO(
                $userId,
                $danceGroupId,
                $date_of_action
            )
        ));
    }
    

    #[Route('/api/visit/list_all_lite_of_user', methods:["POST"])]
    public function listAllLiteOfUser(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];
        $danceGroupId = (array_key_exists("dance_group_id", $parameters) ? (int)$parameters["dance_group_id"] : 0);
        $dateOfActionStr = (array_key_exists("date_of_action", $parameters) ? $parameters["date_of_action"] : null);
        
        return $this->json($this->visitFacade->listAllLiteByUserIdAndCouldOnlyDanceGroupIdOnDateOfAction(
            $userId,
            $danceGroupId,
            $dateOfActionStr
        ));
    }

    #[Route('/api/visit/delete')]
    public function delete(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $visitId = (int)$parameters["visit_id"];
        
        return $this->json($this->visitFacade->deleteByAdmin($visitId));
    }

}
