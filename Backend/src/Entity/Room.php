<?php

// src/Entity/Room.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Room
{
    // La propriété room_id est la clé primaire de l'entité
    #[ORM\Id, ORM\Column(type: "string", length: 10)]
    private string $room_id;

    // Le nom de la salle
    #[ORM\Column(type: "string", length: 100)]
    private string $room_name;

    // La capacité d'accueil de la salle
    #[ORM\Column(type: "integer")]
    private int $capacity;

    // Le bâtiment dans lequel se trouve la salle
    #[ORM\Column(type: "string", length: 100)]
    private string $building;

    // L'étage où se trouve la salle
    #[ORM\Column(type: "integer")]
    private int $floor;

    public function getRoomId(): string
    {
        return $this->room_id;
    }

    public function setRoomId(string $room_id): self
    {
        $this->room_id = $room_id;
        return $this;
    }

    public function getRoomName(): string
    {
        return $this->room_name;
    }

    public function setRoomName(string $room_name): self
    {
        $this->room_name = $room_name;
        return $this;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function getBuilding(): string
    {
        return $this->building;
    }

    public function setBuilding(string $building): self
    {
        $this->building = $building;
        return $this;
    }

    public function getFloor(): int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;
        return $this;
    }
}
