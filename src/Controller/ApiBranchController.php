<?php

namespace App\Controller;

use App\DTO\Branch\BranchEditDTO;
use App\DTO\Branch\BranchNewDTO;
use App\Facade\BranchFacade;
use App\Middleware\AdminMiddleware;
use App\ViewModel\JsonAnswerStatus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiBranchController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private BranchFacade $branchFacade,
        ){

    }

    #[Route("/api/branch/list_all_lites")]
    public function listAllLite(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->branchLiteViewModels = $this->branchFacade->listAllLites();
        return $this->json($jsonAnswerStatus);
    }

    #[Route("/api/branch/add")]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $branch_name = $parameters["name"];
        $coordinates = $parameters["coordinates"];
        $description = $parameters["description"];
        return $this->json($this->branchFacade->add(new BranchNewDTO($branch_name, $coordinates, $description)));
    }

    #[Route("/api/branch/delete", methods:["DELETE"])]
    public function delete(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $branchId = $parameters["branch_id"];
        return $this->json($this->branchFacade->delete($branchId));
    }

    #[Route("/api/branch/get", methods:["POST"])]
    public function get(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $branchId = $parameters["branch_id"];
        return $this->json($this->branchFacade->getFullInfo($branchId));
    }

    #[Route("/api/branch/update", methods:["PUT"])]
    public function update(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $branch_id = $parameters["branch_id"];
        $name = $parameters["name"];
        $coordinates = $parameters["coordinates"];
        $description = $parameters["description"];
        
        return $this->json($this->branchFacade->update(
            new BranchEditDTO(
                $branch_id, 
                $name, 
                $coordinates,
                $description
            )
        ));
    }

}
