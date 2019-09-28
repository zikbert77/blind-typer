<?php

namespace App\Component;

class TextParser
{
    const DELIMITER_ENTER = "\n";
    const DELIMITER_SPACE = ' ';
    const DELIMITER_UNIVERSAL = '%&%';

    private $originalText;
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
    
    public function parseForJs()
    {
        $this->parseTextForJs();
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
    
    private function parseTextForJs()
    {
        $text = $this->originalText;
        $sentences = [];
        $words = [];
        $letters = [];

        $sentences = explode($this->glues[self::DELIMITER_ENTER], $text);
        $i = 0;
        foreach ($sentences as $sentence) {
            $words[$i] = explode($this->glues[self::DELIMITER_SPACE], $sentence);
            $j = 0;
            foreach ($words[$i] as $word) {
                $wordLength = strlen($word);
                for ($letterIterator = 0; $letterIterator < $wordLength; $letterIterator++) {
                    $letters[$word][$j][] = $word[$letterIterator];
                }
                $j++;
            }
            $i++;
        }

        echo "<pre>";
        var_dump($sentences);
        var_dump($words);
        var_dump($letters);
        echo "</pre>";
        exit;
    }

    public function calculateWords(): int
    {
        $text = $this->originalText;
        foreach ($this->glues as $glue) {
            $text = str_replace($glue, self::DELIMITER_UNIVERSAL, $text);
        }

        return count(explode(self::DELIMITER_UNIVERSAL, $text)) ?? 0;
    }

    private function getRules(): array 
    {
        return [self::DELIMITER_ENTER, self::DELIMITER_SPACE];
    }
}