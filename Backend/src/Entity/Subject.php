<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Subject
{
    #[ORM\Id, ORM\Column(type: "string", length: 10)]
    private string $subject_id;

    #[ORM\Column(type: "string", length: 100)]
    private string $subject_name;

    #[ORM\Column(type: "string", length: 20)]
    private string $subject_code;

    #[ORM\Column(type: "string", length: 100)]
    private string $department;

    #[ORM\Column(type: "string", length: 255)]
    private string $description;

    // Getters
    public function getSubjectId(): string
    {
        return $this->subject_id;
    }

    public function getSubjectName(): string
    {
        return $this->subject_name;
    }

    public function getSubjectCode(): string
    {
        return $this->subject_code;
    }

    public function getDepartment(): string
    {
        return $this->department;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    // Setters
    public function setSubjectId(string $subject_id): self
    {
        $this->subject_id = $subject_id;
        return $this;
    }

    public function setSubjectName(string $subject_name): self
    {
        $this->subject_name = $subject_name;
        return $this;
    }

    public function setSubjectCode(string $subject_code): self
    {
        $this->subject_code = $subject_code;
        return $this;
    }

    public function setDepartment(string $department): self
    {
        $this->department = $department;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}
