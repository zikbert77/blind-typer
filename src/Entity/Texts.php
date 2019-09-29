<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TextsRepository")
 */
class Texts
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $text_body;

    /**
     * @ORM\Column(type="text")
     */
    private $parsed_text;

    /**
     * @ORM\Column(type="integer")
     */
    private $words_count;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $letter_counts;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTextBody(): ?string
    {
        return $this->text_body;
    }

    public function setTextBody(string $text_body): self
    {
        $this->text_body = $text_body;

        return $this;
    }

    public function getParsedText(): ?string
    {
        return $this->parsed_text;
    }

    public function setParsedText(string $parsed_text): self
    {
        $this->parsed_text = $parsed_text;

        return $this;
    }

    public function getWordsCount(): ?int
    {
        return $this->words_count;
    }

    public function setWordsCount(int $words_count): self
    {
        $this->words_count = $words_count;

        return $this;
    }

    public function getLetterCounts(): ?int
    {
        return $this->letter_counts;
    }

    public function setLetterCounts(?int $letter_counts): self
    {
        $this->letter_counts = $letter_counts;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
