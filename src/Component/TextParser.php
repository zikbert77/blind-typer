<?php

namespace App\Component;

class TextParser
{
    const DELIMITER_ENTER = "\n";
    const DELIMITER_SPACE = ' ';
    const DELIMITER_UNIVERSAL = '%&%';

    private $originalText;
    private $lettersCount = 0;
    private $glues = [
        self::DELIMITER_ENTER => '%e',
        self::DELIMITER_SPACE => '%s',
    ];
    
    public function __construct(string $originalText)
    {
        $this->originalText = $originalText;
    }

    public function getText(): string
    {
        return $this->originalText;
    }
    
    public function parse()
    {
        $this->prepareText();
        $this->parseText();

        return $this->getText();
    }
    
    public function parseForJs(): string
    {
        $this->parse();
        return $this->parseTextForJs();
    }

    public function calculateWords(): int
    {
        $text = $this->originalText;
        foreach ($this->glues as $glue) {
            $text = str_replace($glue, self::DELIMITER_UNIVERSAL, $text);
        }

        return count(explode(self::DELIMITER_UNIVERSAL, $text)) ?? 0;
    }

    public function calculateLetters(): int
    {
        return $this->lettersCount;
    }

    private function prepareText()
    {
        $text = $this->originalText;
        $text = trim($text);
        $text = strip_tags($text);
        $this->originalText = $text;
    }

    private function parseText()
    {
        foreach ($this->getRules() as $rule) {
            $this->originalText = explode($rule, $this->originalText);
            $this->originalText = implode($this->glues[$rule], $this->originalText);
        }

        $this->originalText = str_replace(
            '%e%s%s%s%s%s%s%s%s%s%s%s%s%s%s%s%s%s%s%s%s',
            $this->glues[self::DELIMITER_ENTER],
            $this->originalText
        );
    }
    
    private function parseTextForJs(): string
    {
        $words = [];
        $parsedText = [];
        $response = '';
        $text = $this->originalText;
        $sentences = explode($this->glues[self::DELIMITER_ENTER], $text);

        $i = 1;
        $this->lettersCount = 0;
        foreach ($sentences as $sentence) {
            $words['sentence-' . $i] = explode($this->glues[self::DELIMITER_SPACE], $sentence);
            foreach ($words['sentence-' . $i] as $word) {
                $wordLength = strlen($word);
                for ($letterIterator = 0; $letterIterator < $wordLength; $letterIterator++) {
                    $letter = $word[$letterIterator];
                    $letterClasses = 'letter letter-' . $this->lettersCount;
                    if (!isset($word[$letterIterator + 1])) {
                        $letterClasses .= ' end-word';
                    }
                    $letter = '<span class="' . $letterClasses . '" data-letter="' . $letter . '">' . $letter . '</span>';
                    $parsedText['sentence-' . $i][$word][$letterIterator] = $letter;
                    $this->lettersCount++;
                }
            }
            $i++;
        }

        foreach ($parsedText as $sentence) {
            foreach ($sentence as $word => $letters) {
                $response .= implode('', $letters);
            }
        }

        return $response;
    }

    private function getRules(): array 
    {
        return [self::DELIMITER_ENTER, self::DELIMITER_SPACE];
    }
}