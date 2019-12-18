<?php

namespace App\Entity;

class CoursesHistory
{
    private $id;

    private $wordsPerMinute;

    private $charsPerMinute;

    private $accuracy;

    private $createdAt;

    private $user;

    private $course;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWordsPerMinute(): ?int
    {
        return $this->wordsPerMinute;
    }

    public function setWordsPerMinute(?int $wordsPerMinute): self
    {
        $this->wordsPerMinute = $wordsPerMinute;

        return $this;
    }

    public function getCharsPerMinute(): ?int
    {
        return $this->charsPerMinute;
    }

    public function setCharsPerMinute(?int $charsPerMinute): self
    {
        $this->charsPerMinute = $charsPerMinute;

        return $this;
    }

    public function getAccuracy(): ?int
    {
        return $this->accuracy;
    }

    public function setAccuracy(?int $accuracy): self
    {
        $this->accuracy = $accuracy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCourse(): ?Courses
    {
        return $this->course;
    }

    public function setCourse(?Courses $course): self
    {
        $this->course = $course;

        return $this;
    }
}
