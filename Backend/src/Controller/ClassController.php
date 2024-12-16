<?php
namespace App\Controller;

use App\Entity\SchoolClass;
use App\Repository\ClassRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ClassController extends AbstractController
{
    #[Route('/classes', name: 'get_classes', methods: ['GET'])]
    public function getClasses(ClassRepository $classRepository): JsonResponse
    {
        $classes = $classRepository->findAll();
        return $this->json($classes);
    }

    #[Route('/class/{class_id}', name: 'get_class', methods: ['GET'])]
    public function getClass(string $class_id, ClassRepository $classRepository): JsonResponse
    {
        $class = $classRepository->find($class_id);

        if (!$class) {
            return $this->json(['message' => 'Class not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($class);
    }

    #[Route('/class', name: 'create_class', methods: ['POST'])]
    public function createClass(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $class = new SchoolClass();
        $class->setClassId($data['class_id']);
        $class->setSubjectId($data['subject_id']);
        $class->setClassName($data['class_name']);
        $class->setStudents($data['students']);  // You may want to link students by IDs

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($class);
        $entityManager->flush();

        return $this->json($class, Response::HTTP_CREATED);
    }

    #[Route('/class/{class_id}', name: 'update_class', methods: ['PUT'])]
    public function updateClass(string $class_id, Request $request, ClassRepository $classRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $class = $classRepository->find($class_id);

        if (!$class) {
            return $this->json(['message' => 'Class not found'], Response::HTTP_NOT_FOUND);
        }

        $class->setClassName($data['class_name']);
        $class->setSubjectId($data['subject_id']);
        $class->setStudents($data['students']);  

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($class);
    }

    #[Route('/class/{class_id}', name: 'delete_class', methods: ['DELETE'])]
    public function deleteClass(string $class_id, ClassRepository $classRepository): JsonResponse
    {
        $class = $classRepository->find($class_id);

        if (!$class) {
            return $this->json(['message' => 'Class not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($class);
        $entityManager->flush();

        return $this->json(['message' => 'Class deleted successfully']);
    }
}
