<?php
// src/Entity/SchoolClass.php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class SchoolClass {
    #[ORM\Id, ORM\Column(type: "string", length: 10)]
    private string $class_id;

    #[ORM\ManyToOne(targetEntity: Subject::class)]
    #[ORM\JoinColumn(name: "subject_id", referencedColumnName: "subject_id")]
    private Subject $subject;

    #[ORM\Column(type: "string", length: 100)]
    private string $class_name;

    #[ORM\Column(type: "json")]
    private array $students = [];

    // Getters and Setters

    public function getClassId(): string
    {
        return $this->class_id;
    }

    public function setClassId(string $class_id): self
    {
        $this->class_id = $class_id;
        return $this;
    }

    public function getSubject(): Subject
    {
        return $this->subject;
    }

    public function setSubject(Subject $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    public function getClassName(): string
    {
        return $this->class_name;
    }

    public function setClassName(string $class_name): self
    {
        $this->class_name = $class_name;
        return $this;
    }

    public function getStudents(): array
    {
        return $this->students;
    }

    public function setStudents(array $students): self
    {
        $this->students = $students;
        return $this;
    }
}
