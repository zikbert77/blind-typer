<?php

namespace App\Entity;

class Languages
{
    // @todo: If you changed language id please also change it in database
    const US = 1;
    const UA = 2;
    const RU = 3;

    const DEFAULT_LANGUAGE = self::US;

    const LANGUAGES_TITLES = [
        self::US => 'Us',
        self::UA => 'Ua',
        self::RU => 'Ru'
    ];

    private $id;

    private $title;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
