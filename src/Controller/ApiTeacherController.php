<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;

use App\Middleware\AdminMiddleware;
use App\Facade\TeacherFacade;
use App\DTO\Teacher\TeacherNewDTO;
use App\DTO\Teacher\TeacherEditByColumnDTO;
use App\DTO\Teacher\TeacherEditDTO;
use App\DTO\Teacher\TecherPosterDTO;
use App\Form\Teacher\TeacherEditByColumnDTOForm;
use App\Form\Teacher\TecherPosterDTOForm;
use App\ViewModel\JsonAnswerStatus;

class ApiTeacherController extends AbstractController
{
    public function __construct(
        private AdminMiddleware $adminMiddleware,
        private TeacherFacade $teacherFacade,
        ){

    }

    #[Route("/api/teacher")]
    public function index(Request $request): JsonResponse
    {
        return $this->json([
            'message' => 'api teacher index',
            'path' => 'src/Controller/ApiTeacherController.php',
        ]);
    }

    #[Route("/api/teacher/get", methods:["POST"])]
    public function get(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $teacher_id = $parameters["teacher_id"];

        return $this->json($this->teacherFacade->getFullInfo($teacher_id));
    }

    #[Route("/api/teacher/add")]
    public function add(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $teacher_name = $parameters["name"];
        return $this->json($this->teacherFacade->add(new TeacherNewDTO($teacher_name)));
    }

    #[Route("/api/teacher/poster/upload")]
    public function posterUpload(Request $request, SluggerInterface $slugger): JsonResponse {

        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $teacherId = (int)$request->request->get('teacher_id');
        //print("teacherId: " . $teacherId . "<br />");
        $uploadedGileByGet = $request->files->get('poster_file');

        if($uploadedGileByGet && $teacherId != 0){
            return $this->json($this->teacherFacade->posterUpload($teacherId, $uploadedGileByGet));
        }

        /*
        $teacherPosterDTO = new TecherPosterDTO();
        $form = $this->createForm(TecherPosterDTOForm::class, $teacherPosterDTO);
        $form->handleRequest($request);
        $form->submit($request->request->all());

        if($form->isSubmitted() && $form->isValid()){
            $teacherPosterDTO = $form->getData();
            var_dump($teacherPosterDTO);
            
            $posterFile = $form->get('poster_file')->getData();
            $teacherId = $form->get('teacher_id')->getData();
            //print("teacherId: " . $teacherId);

            if($posterFile == null)print("posterFile is NULL");

            if ($posterFile) {
                $originalFilename = pathinfo($posterFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$posterFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $posterFile->move("uploads", $newFilename);
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                    throw new FileException("try_save_file: " .$e->getMessage());
                }

            } else {
                return $this->json(new JsonAnswerStatus("error", "no_file"));
            }


            return $this->json(new JsonAnswerStatus("success"));
        }
        */

        return $this->json(new JsonAnswerStatus("error", "no_data"));
    }

    #[Route("/api/teacher/poster/delete")]
    public function posterDelete(Request $request): JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $data = json_decode($request->getContent(), true);
        $teacherId = $data["teacher_id"];
        return $this->json($this->teacherFacade->posterDeleteByTeacherId($teacherId));
    }

    #[Route("/api/teacher/update", methods:["PUT"])]
    public function update(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $parameters = json_decode($request->getContent(), true);
        $teacher_id = $parameters["teacher_id"];
        $name = $parameters["name"];
        $stavka = $parameters["stavka"];
        $min_students = $parameters["min_students"];
        $raz = $parameters["raz"];
        $usual = $parameters["usual"];
        $unlim = $parameters["unlim"];
        $stavka_plus = $parameters["stavka_plus"];
        $plus_after_students = $parameters["plus_after_students"];
        $plus_after_summa = $parameters["plus_after_summa"];
        $procent = $parameters["procent"];

        
        return $this->json($this->teacherFacade->update(
            new TeacherEditDTO(
                $teacher_id, 
                $name, 
                $stavka,
                $min_students,
                $raz,
                $usual,
                $unlim,
                $stavka_plus,
                $plus_after_students,
                $plus_after_summa,
                $procent
            )
        ));
        /*
        $teacherEditByColumnDTO = new TeacherEditByColumnDTO();
        $form = $this->createForm(TeacherEditByColumnDTOForm::class, $teacherEditByColumnDTO);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if($form->isValid()){//$form->isSubmitted() && 
            $teacherEditByColumnDTO = $form->getData();
            //print("teacherId: " . $teacherEditByColumnDTO->getTeacher_id());
            return $this->json($this->teacherFacade->update($teacherEditByColumnDTO));
        } else {
            //print($form->getErrors());
        }
        return $this->json(new JsonAnswerStatus("error", "no_data"));
        */
    }

    #[Route("/api/teacher/list_all_lites")]
    public function listAllLite(Request $request): JsonResponse
    {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $jsonAnswerStatus = new JsonAnswerStatus("success", null);
        $jsonAnswerStatus->teacherLiteViewModels = $this->teacherFacade->listAllLites();
        return $this->json($jsonAnswerStatus);
    }

    #[Route("/api/teacher/delete", methods: ["DELETE"])]
    public function delete(Request $request): JsonResponse {
        $adminId = $this->adminMiddleware->getAdminIdFromJWT($request);
        if($adminId == 0)return $this->json(new JsonAnswerStatus("error", "no_auth"));

        $data = json_decode($request->getContent(), true);
        $teacherId = $data["teacher_id"];
        return $this->json($this->teacherFacade->delete($teacherId));
    }

}
