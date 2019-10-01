<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

class Texts
{
    private $id;

    private $textBody;

    private $wordsCount;

    private $createdAt;

    private $letterCounts;

    private $parsedText;

    private $language;

    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextBody(): ?string
    {
        return $this->textBody;
    }

    public function setTextBody(string $textBody): self
    {
        $this->textBody = $textBody;

        return $this;
    }

    public function getParsedText(): ?string
    {
        return $this->parsedText;
    }

    public function setParsedText(string $parsedText): self
    {
        $this->parsedText = $parsedText;

        return $this;
    }

    public function getWordsCount(): ?int
    {
        return $this->wordsCount;
    }

    public function setWordsCount(int $wordsCount): self
    {
        $this->wordsCount = $wordsCount;

        return $this;
    }

    public function getLetterCounts(): ?int
    {
        return $this->letterCounts;
    }

    public function setLetterCounts(?int $letterCounts): self
    {
        $this->letterCounts = $letterCounts;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getLanguage(): ?Languages
    {
        return $this->language;
    }

    public function setLanguage(?Languages $language): self
    {
        $this->language = $language;

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
}
