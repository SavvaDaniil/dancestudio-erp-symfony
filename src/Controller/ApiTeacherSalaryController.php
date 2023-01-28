<?php

namespace App\Controller;

use App\DTO\TeacherSalary\TeacherSalaryEditDTO;
use App\DTO\TeacherSalary\TeacherSalarySearchDTO;
use App\Facade\TeacherSalaryFacade;
use App\Middleware\AdminMiddleware;
use App\ViewModel\JsonAnswerStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiTeacherSalaryController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private TeacherSalaryFacade $teacherSalaryFacade
        ){

    }

    
    #[Route('/api/teacher_salary/test')]
    public function test(): JsonResponse
    {
        $this->teacherSalaryFacade->autoUpdateAllGroupsOnDateOfAction("2023-01-26");

        return $this->json([
            'message' => 'test',
        ]);
    }


    #[Route("/api/teacher_salary/get_search_prepare", methods: ["GET"])]
    public function searchPrepare(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));
        return $this->json($this->teacherSalaryFacade->getSearchPrepareViewModel());
    }

    #[Route("/api/teacher_salary/search")]
    public function searchLites(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $dateFrom = $parameters["date_from"];
        $dateTo = $parameters["date_to"];
        $danceGroupId = $parameters["dance_group_id"];
        $teacherId = $parameters["teacher_id"];

        return $this->json($this->teacherSalaryFacade->searchLitesByDTO(new TeacherSalarySearchDTO(
            $dateFrom,
            $dateTo,
            $danceGroupId,
            $teacherId
        )));
    }

    #[Route("/api/teacher_salary/get_more_info")]
    public function getMoreInfo(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $teacherSalaryId = (int)$parameters["teacher_salary_id"];

        return $this->json($this->teacherSalaryFacade->getMoreInfoById($teacherSalaryId));
    }

    #[Route("/api/teacher_salary/update", methods: ["PATCH"])]
    public function update(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $teacherSalaryId = (int)$parameters["teacher_salary_id"];
        $name = $parameters["name"];
        $value = (int)$parameters["value"];

        return $this->json($this->teacherSalaryFacade->updateByDTO(
            new TeacherSalaryEditDTO(
                $teacherSalaryId,
                $name,
                $value
            )
        ));
    }

    #[Route("/api/teacher_salary/delete", methods: ["DELETE"])]
    public function delete(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $teacherSalaryId = (int)$parameters["teacher_salary_id"];

        return $this->json($this->teacherSalaryFacade->deleteById($teacherSalaryId));
    }

}
