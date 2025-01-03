<?php

namespace App\Entity;

class Courses
{
    const BASIC_COURSE_GROUP = 1;
    const ADVANCED_COURSE_GROUP = 2;

    const GROUPS_TITLES = [
        self::BASIC_COURSE_GROUP => 'Basic course',
        self::ADVANCED_COURSE_GROUP => 'Advanced course'
    ];

    const PREMIUM_GROUPS_TITLES = [
        self::GROUPS_TITLES[self::ADVANCED_COURSE_GROUP]
    ];

    public static $subGroups = [
        self::BASIC_COURSE_GROUP => [],
        self::ADVANCED_COURSE_GROUP => [],
    ];


    private $id;

    private $groupId;

    private $title;

    private $description;

    private $textBody;

    private $parsedText;

    private $createdAt;

    private $updatedAt;

    private $language;

    private $wordsCount;

    private $letterCount;

    private $position;

    public function __construct()
    {
        if (!$this->getCreatedAt()) {
            $this->setCreatedAt(new \DateTime('now'));
        }

        $this->setUpdatedAt(new \DateTime('now'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupId($onlyId = false)
    {
        return $onlyId ? $this->groupId : self::GROUPS_TITLES[$this->groupId] ?? $this->groupId;
    }

    public function setGroupId(?int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getTextBody(): ?string
    {
        return $this->textBody;
    }

    public function setTextBody(?string $textBody): self
    {
        $this->textBody = $textBody;

        return $this;
    }

    public function getParsedText(): ?string
    {
        return $this->parsedText;
    }

    public function setParsedText(?string $parsedText): self
    {
        $this->parsedText = $parsedText;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getWordsCount(): ?int
    {
        return $this->wordsCount;
    }

    public function setWordsCount(?int $wordsCount): self
    {
        $this->wordsCount = $wordsCount;

        return $this;
    }

    public function getLetterCount(): ?int
    {
        return $this->letterCount;
    }

    public function setLetterCount(?int $letterCount): self
    {
        $this->letterCount = $letterCount;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
