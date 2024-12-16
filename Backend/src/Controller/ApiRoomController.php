<?php
namespace App\Controller;

use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ApiRoomController
{
    #[Route('/api/rooms', name: 'api_rooms', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $rooms = $em->getRepository(Room::class)->findAll();
        return new JsonResponse($rooms);
    }

    #[Route('/api/room/{id}', name: 'api_room', methods: ['GET'])]
    public function show(string $id, EntityManagerInterface $em): JsonResponse
    {
        $room = $em->getRepository(Room::class)->find($id);
        if (!$room) {
            return new JsonResponse(['error' => 'Room not found'], 404);
        }
        return new JsonResponse($room);
    }
}