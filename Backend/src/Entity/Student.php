<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "students")]
class Student
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 10)]
    private string $student_id;

    #[ORM\Column(type: "string", length: 100)]
    private string $first_name;

    #[ORM\Column(type: "string", length: 100)]
    private string $last_name;

    #[ORM\Column(type: "string", length: 100)]
    private string $email;

    public function getStudentId(): string
    {
        return $this->student_id;
    }

    public function setStudentId(string $student_id): self
    {
        $this->student_id = $student_id;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}
