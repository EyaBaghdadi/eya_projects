<?php
namespace App\Controller;

use App\Entity\Student;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class StudentController extends AbstractController
{
    #[Route('/students', name: 'get_students', methods: ['GET'])]
    public function getStudents(StudentRepository $studentRepository): JsonResponse
    {
        $students = $studentRepository->findAll();
        return $this->json($students);
    }

    #[Route('/student/{student_id}', name: 'get_student', methods: ['GET'])]
    public function getStudent(string $student_id, StudentRepository $studentRepository): JsonResponse
    {
        $student = $studentRepository->find($student_id);

        if (!$student) {
            return $this->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($student);
    }

    #[Route('/student', name: 'create_student', methods: ['POST'])]
    public function createStudent(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $student = new Student();
        $student->setStudentId($data['student_id']);
        $student->setFirstName($data['first_name']);
        $student->setLastName($data['last_name']);
        $student->setEmail($data['email']);
        $student->setClassId($data['class_id']);
        $student->setPhone($data['phone']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($student);
        $entityManager->flush();

        return $this->json($student, Response::HTTP_CREATED);
    }

    #[Route('/student/{student_id}', name: 'update_student', methods: ['PUT'])]
    public function updateStudent(string $student_id, Request $request, StudentRepository $studentRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $student = $studentRepository->find($student_id);

        if (!$student) {
            return $this->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $student->setFirstName($data['first_name']);
        $student->setLastName($data['last_name']);
        $student->setEmail($data['email']);
        $student->setClassId($data['class_id']);
        $student->setPhone($data['phone']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($student);
    }

    #[Route('/student/{student_id}', name: 'delete_student', methods: ['DELETE'])]
    public function deleteStudent(string $student_id, StudentRepository $studentRepository): JsonResponse
    {
        $student = $studentRepository->find($student_id);

        if (!$student) {
            return $this->json(['message' => 'Student not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($student);
        $entityManager->flush();

        return $this->json(['message' => 'Student deleted successfully']);
    }
}
