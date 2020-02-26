<?php


namespace Source\Core;


use Source\Models\BlackList;

/**
 * Class Phrases_Analysis
 * @package Source\Core
 */
class Phrases_Analysis
{
    private $blackList;

    public array $segmentsAndRepetitions;

    private string $allText;

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

    private int $minWords;

    private int $minRepetitions;

    public array $uniqueNumberOfWords;

    public array $uniqueNumberOfRepetitions;

    private bool $caseSensitive;

    /**
     * Phrases_Analysis constructor.
     */
    public function __construct()
    {
        $this->blackList = (new BlackList())->load("phrase");

        $this->segmentsAndRepetitions = [];
        $this->wordsSplited = [];
        $this->minWords = 2;
        $this->minRepetitions = 2;
        $this->caseSensitive = false;

        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', '300');
    }

    public function setMinWords(int $num)
    {
        $this->minWords = $num;
        return $this;
    }

    public function caseSensitive(bool $caseSensitive)
    {
        $this->caseSensitive = $caseSensitive;
    }

    public function setMinRepetitions(int $num)
    {
        $this->minRepetitions = $num;
        return $this;
    }


    public function analyze(): ?Phrases_Analysis
    {
        $this->loopSegments();
        krsort($this->segmentsAndRepetitions);
        foreach ($this->segmentsAndRepetitions as $key => $repetition) {
            arsort($this->segmentsAndRepetitions[$key]);
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

        if ($this->caseSensitive) {
            $this->$text = strtolower($text);
        }

        $this->wordsSplited = explode(" ", trim(preg_replace('/\s+/', ' ', $text)));

        $this->clearTrash();

        return $this;
    }

    public function setText(string $text)
    {
        $this->allText = $text;

        return $this;
    }

    public function repetitionsAnalyze(string $segment)
    {
        if ($segment == "") {
            return 0;
        }

        $lastPos = 0;
        $numberTotal = 0;

        if ($this->caseSensitive) {
            $this->$segment = strtolower($segment);
        }

        while (($lastPos = strpos($this->allText, $segment, $lastPos)) !== false) {
            $numberTotal++;
            $lastPos = $lastPos + strlen($segment);
        }

        if (!$numberTotal || $numberTotal == 1) {
            return 0;
        }

        return $numberTotal;

    }

    public function loopSegments()
    {
        for ($i = 0; $i < count($this->wordsSplited); $i++) {
            $numberOfWords = $this->minWords;
            $continue = true;
            while ($continue) {
                $segment = $this->returnSegmentByNumberOfWords($numberOfWords, $i);
                if (!$this->blackList) {
                    $this->blackList[] = "false";
                }
                if (!array_key_exists($segment, $this->segmentsAndRepetitions) && !in_array($segment, $this->blackList)) {
                    $result = $this->repetitionsAnalyze($segment);
                    if ($result < $this->minRepetitions) {
                        $continue = false;
                        $numberOfWords = $this->minWords;
                    } else {
                        $this->segmentsAndRepetitions[$result][$segment] = $numberOfWords;
                        $numberOfWords++;
                    }
                } else {
                    $numberOfWords++;
                }

            }
        }

    }

    private function returnSegmentByNumberOfWords(int $numberOfWords, int $index): string
    {
        $segment = "";
        if (($numberOfWords + $index) <= count($this->wordsSplited)) {
            for ($i = 0; $i < $numberOfWords; $i++) {
                $segment .= $this->wordsSplited[$i + $index] . " ";
            }
            if (substr(trim($segment), -1) == ",") {
                return rtrim(trim($segment), ",");
            }
            if (substr(trim($segment), -1) == ".") {
                return rtrim(trim($segment), ".");
            }
            return trim($segment);
        }
        return "";
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

    public function getUniqueNumberOfRepetitionsAndWords()
    {
        $arrayRepetitionTemp = [];
        $arrayWordsTemp = [];

        foreach ($this->segmentsAndRepetitions as $repetition => $segments) {
            $arrayRepetitionTemp = array_merge([$repetition], $arrayRepetitionTemp);
            foreach ($segments as $numberOfWords) {
                $arrayWordsTemp = array_merge($arrayWordsTemp, [$numberOfWords]);
            }
        }

        $this->uniqueNumberOfRepetitions = $arrayRepetitionTemp;
        $this->uniqueNumberOfWords = array_unique($arrayWordsTemp);
        return $this;
    }

}