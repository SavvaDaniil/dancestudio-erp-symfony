<?php

namespace App\Controller;

use App\DTO\PurchaseAbonement\PurchaseAbonementEditDTO;
use App\DTO\PurchaseAbonement\PurchaseAbonementNewDTO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Middleware\AdminMiddleware;
use App\Facade\PurchaseAbonementFacade;
use App\ViewModel\JsonAnswerStatus;


class ApiPurchaseAbonementController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private PurchaseAbonementFacade $purchaseAbonementFacade,
        ){

    }

    #[Route('/api/purchase_abonement/get_for_edit', methods:["POST"])]
    public function getForEdit(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $purchaseAbonementId = (int)$parameters["purchase_abonement_id"];
        
        return $this->json($this->purchaseAbonementFacade->getForEditById($purchaseAbonementId));
    }

    #[Route('/api/purchase_abonement/update', methods:["PUT"])]
    public function updateByAdmin(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $purchaseAbonementId = (int)$parameters["purchase_abonement_id"];
        $price = (int)$parameters["price"];
        $cashless = (int)$parameters["cashless"];
        $visitsStart = (int)$parameters["visits_start"];
        $visitsLeft = (int)$parameters["visits_left"];
        $days = (int)$parameters["days"];
        $dateOfBuy = (array_key_exists("date_of_buy", $parameters) ? $parameters["date_of_buy"] : null);
        $dateOfActivation = (array_key_exists("date_of_activation", $parameters) ? $parameters["date_of_activation"] : null);
        $dateOfMustBeUsedTo = (array_key_exists("date_of_must_be_used_to", $parameters) ? $parameters["date_of_must_be_used_to"] : null);
        $comment = (array_key_exists("comment", $parameters) ? $parameters["comment"] : null);
        
        return $this->json($this->purchaseAbonementFacade->updateByDTO(new PurchaseAbonementEditDTO(
            $purchaseAbonementId,
            $price,
            $cashless,
            $visitsStart,
            $visitsLeft,
            $days,
            $dateOfBuy,
            $dateOfActivation,
            $dateOfMustBeUsedTo,
            $comment
        )));
    }

    #[Route('/api/purchase_abonement/add')]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];
        $abonementId = (int)$parameters["abonement_id"];
        $danceGroupId = (array_key_exists("dance_group_id", $parameters) ? (int)$parameters["dance_group_id"] : 0);
        $price = (int)$parameters["price"];
        $cashless = (int)$parameters["cashless"];
        $visits = (int)$parameters["visits"];
        $days = (int)$parameters["days"];
        $comment = $parameters["comment"];
        $date_of_buy = $parameters["date_of_buy"];
        
        return $this->json($this->purchaseAbonementFacade->addByDTO(new PurchaseAbonementNewDTO(
            $userId,
            $abonementId,
            $danceGroupId,
            $price,
            $cashless,
            $visits,
            $days,
            $comment,
            $date_of_buy
        )));
    }

    #[Route('/api/purchase_abonement/delete', methods:["DELETE"])]
    public function delete(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $purchaseAbonementId = (int)$parameters["purchase_abonement_id"];
        
        return $this->json($this->purchaseAbonementFacade->deleteByAdmin($purchaseAbonementId));
    }

    #[Route('/api/purchase_abonement/list_all_active_for_user_by_date')]
    public function listAllActiveByUserIdAndDateOfAction(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];
        $danceGroupId = (array_key_exists("dance_group_id", $parameters) ? (int)$parameters["dance_group_id"] : 0);
        $date_of_buy = $parameters["date_of_buy"];
        
        return $this->json($this->purchaseAbonementFacade->listAllLiteActiveByUserIdAndDanceGroupIdAndDateOfAction($userId, $danceGroupId, $date_of_buy));
    }

    #[Route('/api/purchase_abonement/list_all_lite_of_user')]
    public function listAllLitesByUserId(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $userId = (int)$parameters["user_id"];
        
        return $this->json($this->purchaseAbonementFacade->listAllLiteByUserId($userId));
    }
}
