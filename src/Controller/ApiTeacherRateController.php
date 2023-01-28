<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use App\Facade\TeacherRateFacade;
use App\DTO\TeacherRate\TeacherRateNewDTO;
use App\DTO\TeacherRate\TeacherRateEditDTO;
use App\Middleware\AdminMiddleware;
use App\ViewModel\JsonAnswerStatus;

class ApiTeacherRateController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private TeacherRateFacade $teacherRateFacade
        ){

    }

    #[Route('/api/teacher_rate', name: 'app_api_teacher_rate')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your api_teacher_rate controller!',
            'path' => 'src/Controller/ApiTeacherRateController.php',
        ]);
    }

    #[Route("/api/teacher_rate/add")]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        if(!array_key_exists("teacher_id", $parameters))return $this->json(new JsonAnswerStatus("error", "no teacher_id"));
        //if(!array_key_exists("students", $parameters))return $this->json(new JsonAnswerStatus("error", "no students"));
        //if(!array_key_exists("how_much_money", $parameters))return $this->json(new JsonAnswerStatus("error", "no how_much_money"));

        $teacherId = (int)$parameters["teacher_id"];
        //$students = (int)$parameters["students"];
        //$how_much_money = (int)$parameters["how_much_money"];

        //$teacherRateNewDTO = new TeacherRateNewDTO($teacherId, $students, $how_much_money);
        return $this->json($this->teacherRateFacade->add($teacherId));
    }

    #[Route("/api/teacher_rate/delete", methods: ["DELETE"])]
    public function delete(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        if(!array_key_exists("teacher_rate_id", $parameters))return $this->json(new JsonAnswerStatus("error", "no teacher_rate_id"));
        $teacherRateId = (int)$parameters["teacher_rate_id"];
        return $this->json($this->teacherRateFacade->deleteById($teacherRateId));
    }

    #[Route("/api/teacher_rate/update", methods: ["PATCH"])]
    public function update(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        if(!array_key_exists("teacher_rate_id", $parameters))return $this->json(new JsonAnswerStatus("error", "no teacher_rate_id"));
        if(!array_key_exists("name", $parameters))return $this->json(new JsonAnswerStatus("error", "no name"));
        if(!array_key_exists("value", $parameters))return $this->json(new JsonAnswerStatus("error", "no value"));

        $teacherRateId = (int)$parameters["teacher_rate_id"];
        $name = (string)$parameters["name"];
        $value = (int)$parameters["value"];
        return $this->json($this->teacherRateFacade->update(new TeacherRateEditDTO($teacherRateId, $name, $value)));
    }


}
