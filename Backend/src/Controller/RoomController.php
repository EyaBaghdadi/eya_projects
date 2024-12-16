<?php
namespace App\Controller;

use App\Entity\Room;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class RoomController extends AbstractController
{
    private $entityManager;
    private $roomRepository;

    public function __construct(EntityManagerInterface $entityManager, RoomRepository $roomRepository)
    {
        $this->entityManager = $entityManager;
        $this->roomRepository = $roomRepository;
    }

    #[Route('/rooms', name: 'get_rooms', methods: ['GET'])]
    public function getRooms(): JsonResponse
    {
        $rooms = $this->roomRepository->findAll();
        return $this->json($rooms);
    }

    #[Route('/room/{room_id}', name: 'get_room', methods: ['GET'])]
    public function getRoom(string $room_id): JsonResponse
    {
        $room = $this->roomRepository->find($room_id);

        if (!$room) {
            return $this->json(['message' => 'Room not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->json($room);
    }

    #[Route('/room', name: 'create_room', methods: ['POST'])]
    public function createRoom(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $room = new Room();
        $room->setRoomId($data['room_id']);
        $room->setRoomName($data['room_name']);
        $room->setCapacity($data['capacity']);
        $room->setBuilding($data['building']);
        $room->setFloor($data['floor']);

        $this->entityManager->persist($room);
        $this->entityManager->flush();

        return $this->json($room, Response::HTTP_CREATED);
    }

    #[Route('/room/{room_id}', name: 'update_room', methods: ['PUT'])]
    public function updateRoom(string $room_id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $room = $this->roomRepository->find($room_id);

        if (!$room) {
            return $this->json(['message' => 'Room not found'], Response::HTTP_NOT_FOUND);
        }

        $room->setRoomName($data['room_name']);
        $room->setCapacity($data['capacity']);
        $room->setBuilding($data['building']);
        $room->setFloor($data['floor']);

        $this->entityManager->flush();

        return $this->json($room);
    }

    #[Route('/room/{room_id}', name: 'delete_room', methods: ['DELETE'])]
    public function deleteRoom(string $room_id): JsonResponse
    {
        $room = $this->roomRepository->find($room_id);

        if (!$room) {
            return $this->json(['message' => 'Room not found'], Response::HTTP_NOT_FOUND);
        }

        $this->entityManager->remove($room);
        $this->entityManager->flush();

        return $this->json(['message' => 'Room deleted successfully']);
    }
}