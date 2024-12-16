<?php
namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class TeacherController extends AbstractController
{
    private $entityManager;
    private $teacherRepository;

    public function __construct(EntityManagerInterface $entityManager, TeacherRepository $teacherRepository)
    {
        $this->entityManager = $entityManager;
        $this->teacherRepository = $teacherRepository;
    }

    #[Route('/teachers', name: 'get_teachers', methods: ['GET'])]
    public function getTeachers(): JsonResponse
    {
        $teachers = $this->teacherRepository->findAll();
        return $this->json($teachers);
    }

    #[Route('/teacher/{teacher_id}', name: 'get_teacher', methods: ['GET'])]
    public function getTeacher(string $teacher_id): JsonResponse
    {
        $teacher = $this->teacherRepository->find($teacher_id);

        if (!$teacher) {
            return $this->json(['message' => 'Teacher not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($teacher);
    }

    #[Route('/teacher', name: 'create_teacher', methods: ['POST'])]
    public function createTeacher(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $teacher = new Teacher();
        $teacher->setTeacherId($data['teacher_id']);
        $teacher->setFirstName($data['first_name']);
        $teacher->setLastName($data['last_name']);
        $teacher->setEmail($data['email']);
        $teacher->setDepartment($data['department']);
        $teacher->setPhone($data['phone']);

        $this->entityManager->persist($teacher);
        $this->entityManager->flush();

        return $this->json($teacher, Response::HTTP_CREATED);
    }

    #[Route('/teacher/{teacher_id}', name: 'update_teacher', methods: ['PUT'])]
    public function updateTeacher(string $teacher_id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $teacher = $this->teacherRepository->find($teacher_id);

        if (!$teacher) {
            return $this->json(['message' => 'Teacher not found'], Response::HTTP_NOT_FOUND);
        }

        $teacher->setFirstName($data['first_name']);
        $teacher->setLastName($data['last_name']);
        $teacher->setEmail($data['email']);
        $teacher->setDepartment($data['department']);
        $teacher->setPhone($data['phone']);

        $this->entityManager->flush();

        return $this->json($teacher);
    }

    #[Route('/teacher/{teacher_id}', name: 'delete_teacher', methods: ['DELETE'])]
    public function deleteTeacher(string $teacher_id): JsonResponse
    {
        $teacher = $this->teacherRepository->find($teacher_id);

        if (!$teacher) {
            return $this->json(['message' => 'Teacher not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($teacher);
        $this->entityManager->flush();

        return $this->json(['message' => 'Teacher deleted successfully']);
    }
}