<?php

namespace App\Component;

class TextParser
{
    const DELIMITER_ENTER = "\r";
    const DELIMITER_NEXT_ROW = "\n";
    const DELIMITER_SPACE = ' ';
    const DELIMITER_DASH = '-';
    const DELIMITER_POINT = '.';
    const DELIMITER_UNIVERSAL = '%&%';

    private $originalText;
    private $lettersCount = 0;
    private $glues = [
        self::DELIMITER_NEXT_ROW => '%e',
        self::DELIMITER_SPACE => '%s',
    ];
    private $replacements = [
        '—' => '-',
        '’' => '\'',
        '‘' => '\'',
        '“' => '"',
        '”' => '"',
    ];
    
    public function __construct(string $originalText = null)
    {
        $this->originalText = $originalText;
    }

    public function setOriginalText(string $originalText)
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

        foreach ($this->replacements as $replace => $replacement) {
            $text = str_replace($replace, $replacement, $text);
        }

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
            $this->glues[self::DELIMITER_NEXT_ROW],
            $this->originalText
        );
    }
    
    private function parseTextForJs(): string
    {
        $words = [];
        $parsedText = [];
        $response = '';
        $text = $this->originalText;
        $sentences = explode($this->glues[self::DELIMITER_NEXT_ROW], $text);

        $i = 1;
        $this->lettersCount = 0;
        foreach ($sentences as $sentence) {
            $words['sentence-' . $i] = explode($this->glues[self::DELIMITER_SPACE], $sentence);
            foreach ($words['sentence-' . $i] as $key => $word) {
                $word .= strpos($word, self::DELIMITER_ENTER) == false ? self::DELIMITER_SPACE : '';
                $wordArray = preg_split('//u', $word, null, PREG_SPLIT_NO_EMPTY);
                $wordLength = count($wordArray);
                if (isset($wordArray[$wordLength - 2]) && $wordArray[$wordLength - 2] == '.' && $wordArray[$wordLength - 1] == self::DELIMITER_SPACE) {
                    $wordArray[$wordLength - 1] = self::DELIMITER_ENTER;
                }
                for ($letterIterator = 0; $letterIterator < $wordLength; $letterIterator++) {
                    $newRow = '';
                    $letter = $wordArray[$letterIterator];
                    $letterClasses = 'letter letter-' . $this->lettersCount;
                    if (
                        isset($wordArray[$letterIterator + 1]) &&
                            (
                                $wordArray[$letterIterator + 1] == self::DELIMITER_SPACE ||
                                $wordArray[$letterIterator + 1] == self::DELIMITER_DASH ||
                                $wordArray[$letterIterator + 1] == self::DELIMITER_POINT
                            ) &&
                        $wordLength > 2
                    ) {
                        $letterClasses .= ' end-word';
                    }

                    $displayedLetter = $letter;
                    if ($letter == self::DELIMITER_ENTER) {
                        $displayedLetter = '⏎' . self::DELIMITER_ENTER;
                        $newRow = '<br>';
                    } elseif ($letter == self::DELIMITER_SPACE) {
                        $displayedLetter = '&nbsp;' . self::DELIMITER_SPACE;
                        $letterClasses .= ' space';
                    } elseif ($letter == '"') {
                        $letter = '&quot;';
                    }

                    $letter = '<span class="' . $letterClasses . '" data-letter="' . $letter . '">' . $displayedLetter . '</span>' . $newRow;
                    $parsedText['sentence-' . $i][$word . $key][$letterIterator] = $letter;
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

        $lastSpace = '<span class="letter letter-'. ($this->lettersCount - 1) .' space" data-letter=" ">&nbsp; </span>';
        $lastSpacePosition = strpos($response, $lastSpace);
        if ($lastSpacePosition !== false) {
            $response = str_replace($lastSpace, '<span class="letter letter-'. ($this->lettersCount - 1) .' end"></span>', $response);
        }

        return $response;
    }

    private function getRules(): array 
    {
        return [self::DELIMITER_NEXT_ROW, self::DELIMITER_SPACE];
    }
}