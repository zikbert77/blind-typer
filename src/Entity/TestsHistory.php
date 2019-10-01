<?php

namespace App\Entity;

class TestsHistory
{
    private $id;

    private $testDuration;

    private $wordsPerMinute;

    private $charsPerMinute;

    private $accuracy;

    private $createdAt;

    private $user;

    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestDuration(): ?bool
    {
        return $this->testDuration;
    }

    public function setTestDuration(?bool $testDuration): self
    {
        $this->testDuration = $testDuration;

        return $this;
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

    public function getText(): ?Texts
    {
        return $this->text;
    }

    public function setText(?Texts $text): self
    {
        $this->text = $text;

        return $this;
    }
}
