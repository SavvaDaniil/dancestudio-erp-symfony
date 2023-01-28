<?php

namespace App\Controller;

use App\DTO\DanceGroup\DanceGroupEditDTO;
use App\DTO\DanceGroup\DanceGroupNewDTO;
use App\Facade\DanceGroupFacade;
use App\Middleware\AdminMiddleware;
use App\ViewModel\JsonAnswerStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiDanceGroupController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private DanceGroupFacade $danceGroupFacade,
        ){

    }

    #[Route("/api/dance_group/update", methods: ["PUT"])]
    public function update(Request $request): JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $data = json_decode($request->getContent(), true);
        $danceGroupId = (int)$data["dance_group_id"];
        $name = $data["name"];
        $teacher_id = (int)$data["teacher_id"];
        $description = $data["description"];
        $status = (int)$data["status"];
        $status_for_app = (int)$data["status_for_app"];
        $status_of_creative = (int)$data["status_of_creative"];
        $branch_id = (int)$data["branch_id"];
        $is_active_reservation = (int)$data["is_active_reservation"];
        $is_event = (int)$data["is_event"];
        $is_abonements_allow_all = (int)$data["is_abonements_allow_all"];
        return $this->json($this->danceGroupFacade->update(new DanceGroupEditDTO(
            $danceGroupId,
            $name,
            $teacher_id,
            $description,
            $status,
            $status_for_app,
            $status_of_creative,
            $branch_id,
            $is_active_reservation,
            $is_event,
            $is_abonements_allow_all
        )));
    }

    #[Route("/api/dance_group/get_edit", methods: ["POST"])]
    public function getEdit(Request $request): JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $data = json_decode($request->getContent(), true);
        $danceGroupId = $data["dance_group_id"];
        return $this->json($this->danceGroupFacade->getEditViewModelById($danceGroupId));
    }


    
    #[Route("/api/dance_group/get_schedule_by_date", methods: ["POST"])]
    public function getScheduleByDate(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $date_str = $parameters["date_str"];

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->danceGroupLessonViewModels = $this->danceGroupFacade->listAllLikeScheduleByDate($date_str);
        return $this->json($jsonAnswerStatus);
    }
    
    #[Route("/api/dance_group/list_all_edit_previews", methods: ["GET"])]
    public function listAllEditPreviews(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->danceGroupEditPreviewViewModels = $this->danceGroupFacade->listAllEditPreviews();
        return $this->json($jsonAnswerStatus);
    }

    #[Route("/api/dance_group/add")]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $danceGroupName = $parameters["name"];
        return $this->json($this->danceGroupFacade->add(new DanceGroupNewDTO($danceGroupName)));
    }

    #[Route("/api/dance_group/delete", methods: ["DELETE"])]
    public function delete(Request $request): JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $data = json_decode($request->getContent(), true);
        $danceGroupId = $data["dance_group_id"];
        return $this->json($this->danceGroupFacade->delete($danceGroupId));
    }



}
