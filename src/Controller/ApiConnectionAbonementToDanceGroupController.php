<?php

namespace App\Controller;

use App\DTO\ConnectionAbonementToDanceGroup\ConnectionAbonementToDanceGroupEditDTO;
use App\Entity\ConnectionAbonementToDanceGroup;
use App\Facade\ConnectionAbonementToDanceGroupFacade;
use App\Middleware\AdminMiddleware;
use App\ViewModel\JsonAnswerStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiConnectionAbonementToDanceGroupController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private ConnectionAbonementToDanceGroupFacade $connectionAbonementToDanceGroupFacade
        ){

    }

    #[Route("/api/connection_abonement_to_dance_group/update", methods: ["PUT"])]
    public function update(Request $request): JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $data = json_decode($request->getContent(), true);
        $danceGroupId = (int)$data["dance_group_id"];
        $abonementId = (int)$data["abonement_id"];
        $value = (int)$data["value"];
        return $this->json($this->connectionAbonementToDanceGroupFacade->update(new ConnectionAbonementToDanceGroupEditDTO($danceGroupId, $abonementId, $value)));
    }
}
