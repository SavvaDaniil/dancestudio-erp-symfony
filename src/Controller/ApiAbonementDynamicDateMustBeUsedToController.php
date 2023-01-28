<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;

use App\Facade\AbonementDynamicDateMustBeUsedToFacade;
use App\DTO\Teacher\TeacherNewDTO;
use App\DTO\Teacher\TeacherEditByColumnDTO;
use App\DTO\Teacher\TecherPosterDTO;
use App\Form\Teacher\TeacherEditByColumnDTOForm;
use App\Form\Teacher\TecherPosterDTOForm;
use App\ViewModel\JsonAnswerStatus;

class ApiAbonementDynamicDateMustBeUsedToController extends AbstractController {

    public function __construct(
        private AbonementDynamicDateMustBeUsedToFacade $abonementDynamicDateMustBeUsedToFacade,
        ){

    }

    /*
    #[Route("/api/abonement_dynamic_date_must_be_used_to/add")]
    public function add(Request $request): JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        //$teacher_name = $parameters["name"];

        
        return $this->json($this->teacherFacade->add(new TeacherNewDTO($teacher_name)));
    }
    */

}