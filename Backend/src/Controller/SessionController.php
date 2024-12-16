<?php
namespace App\Controller;

use App\Entity\Session;
use App\Repository\SessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class SessionController extends AbstractController
{
    #[Route('/sessions', name: 'get_sessions', methods: ['GET'])]
    public function getSessions(SessionRepository $sessionRepository): JsonResponse
    {
        $sessions = $sessionRepository->findAll();
        return $this->json($sessions);
    }

    #[Route('/session/{session_id}', name: 'get_session', methods: ['GET'])]
    public function getSession(string $session_id, SessionRepository $sessionRepository): JsonResponse
    {
        $session = $sessionRepository->find($session_id);

        if (!$session) {
            return $this->json(['message' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($session);
    }

    #[Route('/session', name: 'create_session', methods: ['POST'])]
    public function createSession(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $session = new Session();
        $session->setSessionId($data['session_id']);
        $session->setStartTime($data['start_time']);
        $session->setEndTime($data['end_time']);
        $session->setClass($data['class_id']);
        $session->setTeacher($data['teacher_id']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($session);
        $entityManager->flush();

        return $this->json($session, Response::HTTP_CREATED);
    }

    #[Route('/session/{session_id}', name: 'update_session', methods: ['PUT'])]
    public function updateSession(string $session_id, Request $request, SessionRepository $sessionRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $session = $sessionRepository->find($session_id);

        if (!$session) {
            return $this->json(['message' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        $session->setStartTime($data['start_time']);
        $session->setEndTime($data['end_time']);
        $session->setClass($data['class_id']);
        $session->setTeacher($data['teacher_id']);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->json($session);
    }

    #[Route('/session/{session_id}', name: 'delete_session', methods: ['DELETE'])]
    public function deleteSession(string $session_id, SessionRepository $sessionRepository): JsonResponse
    {
        $session = $sessionRepository->find($session_id);

        if (!$session) {
            return $this->json(['message' => 'Session not found'], Response::HTTP_NOT_FOUND);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($session);
        $entityManager->flush();

        return $this->json(['message' => 'Session deleted successfully']);
    }
}
