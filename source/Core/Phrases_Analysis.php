<?php


namespace Source\Core;


/**
 * Class Phrases_Analysis
 * @package Source\Core
 */
class Phrases_Analysis
{
    private $blackList;

    /**
     * @var array
     */
    public array $wordsSplited;

    /**
     * @var array
     */
    public array $segmentsByNumberOfWords;

    /**
     * @var array
     */
    public array $unionArrays;

    /**
     * Phrases_Analysis constructor.
     */
    public function __construct()
    {
        $this->unionArrays = [];
        $this->segmentsByNumberOfWords = [];
        $this->wordsSplited = [];
    }

    public function analyze(int $NumberOfWords = 5): ?Phrases_Analysis
    {
        $totalWords = count($this->wordsSplited);
        if ($totalWords || $NumberOfWords <= $totalWords) {
            for ($i = $NumberOfWords; $i > 1; $i--) {
                $this->unionByNumberOfWords($i);
            }
        } else {
            return null;
        }
        return $this;
    }


    /**
     * @param string $text
     * @return Phrases_Analysis|null
     */
    public function getWordsAndSplit(string $text): ?Phrases_Analysis
    {
        if (!strpos($text, " ")) {
            return null;
        }
        $this->wordsSplited = explode(" ", trim(preg_replace('/\s+/', ' ', $text)));

        $this->clearTrash();

        return $this;
    }

    /**
     * @return Phrases_Analysis|null
     */
    private function clearTrash(): ?Phrases_Analysis
    {
        if (!$this->wordsSplited) {
            return null;
        }

        foreach ($this->wordsSplited as $key => $words) {
            if (!$this->wordsSplited[$key]) {
                unset($this->wordsSplited[$key]);
            }
        }

        return $this;
    }

    /**
     * @param int $words
     * @return Phrases_Analysis|null
     */
    public function unionByNumberOfWords(int $words): ?Phrases_Analysis
    {
        if ((count($this->wordsSplited) < $words)) {
            return null;
        }

        if (isset($this->segmentsByNumberOfWords[$words])) {
            unset($this->segmentsByNumberOfWords[$words]);
        }

        $actualPointer = $words;
        foreach ($this->wordsSplited as $word) {
            $actualString = "";
            for ($i = $words; $i > 0; $i--) {
                if ($actualPointer - $i < count($this->wordsSplited)) {
                    $actualString .= $this->wordsSplited[$actualPointer - $i] . " ";
                }
            }

            $actualString = trim($actualString);

            /* TRATAMENTO DA VIRGULA **********
            if (substr($actualString, -1) == ",") {
                $actualString = rtrim($actualString, ",");
            }
            */

            $actualPointer++;
            if (!isset($this->segmentsByNumberOfWords[$words][$actualString])) {
                $this->segmentsByNumberOfWords[$words][$actualString] = 1;
            } else {
                $this->segmentsByNumberOfWords[$words][$actualString]++;
            }
        }

        arsort($this->segmentsByNumberOfWords[$words]);

        return $this;
    }

    /**
     * @param int $numberOfWords
     * @return Phrases_Analysis|null
     */
    public function clearUniqWords(int $numberOfWords): ?Phrases_Analysis
    {
        if (!$this->segmentsByNumberOfWords) {
            return null;
        }


        foreach ($this->segmentsByNumberOfWords as $keySeg => $result) {
            foreach ($result as $key => $words) {
                if ($words < $numberOfWords) {
                    unset($this->segmentsByNumberOfWords[$keySeg][$key]);
                }

            }
        }

        return $this;
    }

    /**
     * @return Phrases_Analysis|null
     */
    public function unionArrays(): ?Phrases_Analysis
    {
        if (!$this->segmentsByNumberOfWords) {
            return null;
        }

        foreach ($this->segmentsByNumberOfWords as $keySeg => $result) {
            $this->unionArrays = array_merge($this->unionArrays, $result);
        }

        arsort($this->unionArrays);

        return $this;

    }

}