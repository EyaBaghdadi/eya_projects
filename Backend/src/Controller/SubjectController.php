<?php
namespace App\Controller;

use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SubjectController extends AbstractController
{
    #[Route('/subjects', name: 'get_subjects', methods: ['GET'])]
    public function getSubjects(SubjectRepository $subjectRepository): JsonResponse
    {
        $subjects = $subjectRepository->findAll();
        return $this->json($subjects);
    }

    #[Route('/subject/{subject_id}', name: 'get_subject', methods: ['GET'])]
    public function getSubject(string $subject_id, SubjectRepository $subjectRepository): JsonResponse
    {
        $subject = $subjectRepository->find($subject_id);

        if (!$subject) {
            return $this->json(['message' => 'Subject not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($subject);
    }

    #[Route('/subject', name: 'create_subject', methods: ['POST'])]
    public function createSubject(Request $request, SubjectRepository $subjectRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $subject = new Subject();
        $subject->setSubjectId($data['subject_id']);
        $subject->setSubjectName($data['subject_name']);
        $subject->setSubjectCode($data['subject_code']);
        $subject->setDepartment($data['department']);
        $subject->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($subject);
        $entityManager->flush();

        return $this->json($subject, Response::HTTP_CREATED);
    }

    #[Route('/subject/{subject_id}', name: 'update_subject', methods: ['PUT'])]
    public function updateSubject(string $subject_id, Request $request, SubjectRepository $subjectRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $subject = $subjectRepository->find($subject_id);

        if (!$subject) {
            return $this->json(['message' => 'Subject not found'], Response::HTTP_NOT_FOUND);
        }

        $subject->setSubjectName($data['subject_name']);
        $subject->setSubjectCode($data['subject_code']);
        $subject->setDepartment($data['department']);
        $subject->setDescription($data['description']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($subject);
    }

    #[Route('/subject/{subject_id}', name: 'delete_subject', methods: ['DELETE'])]
    public function deleteSubject(string $subject_id, SubjectRepository $subjectRepository): JsonResponse
    {
        $subject = $subjectRepository->find($subject_id);

        if (!$subject) {
            return $this->json(['message' => 'Subject not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($subject);
        $entityManager->flush();

        return $this->json(['message' => 'Subject deleted successfully']);
    }
}