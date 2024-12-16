<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Session
{
    #[ORM\Id, ORM\Column(type: "string", length: 10)]
    private string $session_id;

    #[ORM\Column(type: "string", length: 10)]
    private string $subject_id;

    #[ORM\Column(type: "string", length: 10)]
    private string $room_id;

    #[ORM\Column(type: "string", length: 10)]
    private string $class_id;

    #[ORM\Column(type: "datetime")]
    private \DateTime $session_date;

    #[ORM\Column(type: "time")]
    private \DateTime $start_time;

    #[ORM\Column(type: "time")]
    private \DateTime $end_time;

    // Relation ManyToOne avec Teacher
    #[ORM\ManyToOne(targetEntity: Teacher::class)]
    #[ORM\JoinColumn(name: "teacher_id", referencedColumnName: "teacher_id")]
    private Teacher $teacher;

    // Getter et Setter pour teacher
    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher): self
    {
        $this->teacher = $teacher;
        return $this;
    }

    // Autres getters et setters pour les autres propriétés...
}
?>
