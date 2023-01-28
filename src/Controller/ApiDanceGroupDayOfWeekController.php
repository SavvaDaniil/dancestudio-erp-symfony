<?php

namespace App\Controller;

use App\DTO\DanceGroupDayOfWeek\DanceGroupDayOfWeekNewDTO;
use App\DTO\DanceGroupDayOfWeek\DanceGroupDayOfWeekPatchDTO;
use App\Facade\DanceGroupDayOfWeekFacade;
use App\Middleware\AdminMiddleware;
use App\ViewModel\JsonAnswerStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiDanceGroupDayOfWeekController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private DanceGroupDayOfWeekFacade $danceGroupDayOfWeekFacade,
        ){

    }

    #[Route("/api/dance_group_day_of_week/add")]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $dance_group_id = (int)$parameters["dance_group_id"];
        $is_event = (bool)$parameters["is_event"];
        return $this->json($this->danceGroupDayOfWeekFacade->add(new DanceGroupDayOfWeekNewDTO($dance_group_id, $is_event)));
    }

    #[Route("/api/dance_group_day_of_week/update", methods: ["PATCH"])]
    public function update(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        if(!array_key_exists("dance_group_day_of_week_id", $parameters))return $this->json(new JsonAnswerStatus("error", "no teacher_rate_id"));
        if(!array_key_exists("name", $parameters))return $this->json(new JsonAnswerStatus("error", "no name"));
        if(!array_key_exists("value", $parameters))return $this->json(new JsonAnswerStatus("error", "no value"));

        $dance_group_day_of_week_id = (int)$parameters["dance_group_day_of_week_id"];
        $name = (string)$parameters["name"];
        $value = (string)$parameters["value"];
        return $this->json($this->danceGroupDayOfWeekFacade->patch(new DanceGroupDayOfWeekPatchDTO($dance_group_day_of_week_id, $name, $value)));
    }

    #[Route("/api/dance_group_day_of_week/delete", methods: ["DELETE"])]
    public function delete(Request $request): JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $data = json_decode($request->getContent(), true);
        $dance_group_day_of_week_id = $data["dance_group_day_of_week_id"];
        return $this->json($this->danceGroupDayOfWeekFacade->delete($dance_group_day_of_week_id));
    }


}
