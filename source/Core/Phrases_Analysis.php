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

    /**
     * Phrases_Analysis constructor.
     */
    public function __construct()
    {
        $this->blackList = (new BlackList())->load("phrase");

        $this->unionArrays = [];
        $this->segmentsByNumberOfWords = [];
        $this->segmentsAndRepetitions = [];
        $this->wordsSplited = [];
        $this->minWords = 2;
        $this->minRepetitions = 2;
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', '300');
    }

    public function setMinWords(int $num)
    {
        $this->minWords = $num;
    }

    public function setMinRepetitions(int $num)
    {
        $this->minRepetitions = $num;
    }


    public function analyze(): ?Phrases_Analysis
    {
        $this->loopSegments();
        krsort($this->segmentsAndRepetitions);
        foreach ($this->segmentsAndRepetitions as $key => $repetition){
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
        $this->wordsSplited = explode(" ", trim(preg_replace('/\s+/', ' ', $text)));

        $this->clearTrash();

        return $this;
    }

    public function setText(string $text)
    {
        $this->allText = $text;
    }

    public function repetitionsAnalyze(string $segment)
    {
        if ($segment == "") {
            return 0;
        }

        $lastPos = 0;
        $numberTotal = 0;
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
                if(!$this->blackList) {
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

    public function returnSegmentByNumberOfWords(int $numberOfWords, int $index): string
    {
        $segment = "";
        if (($numberOfWords + $index) <= count($this->wordsSplited)) {
            for ($i = 0; $i < $numberOfWords; $i++) {
                $segment .= $this->wordsSplited[$i + $index] . " ";
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

    /**
     * @param int $words
     * @return Phrases_Analysis|null
     */
    public function unionByNumberOfWords(int $words): ?Phrases_Analysis
    {
        if ((count($this->wordsSplited) < $words)) {
            return null;
        }

//        if (isset($this->segmentsByNumberOfWords[$words])) {
//            unset($this->segmentsByNumberOfWords[$words]);
//        }

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

            if (!in_array($actualString, $this->blackList)) {
                $tempSegment = $this->repetitionsAnalyze($actualString);
                if ($tempSegment) {
                    $this->segmentsByNumberOfWords = array_merge($this->segmentsByNumberOfWords, $tempSegment);
                }
            }


            $actualPointer++;
//            if (!isset($this->segmentsByNumberOfWords[$words][$actualString])) {
//                $this->segmentsByNumberOfWords[$words][$actualString] = 1;
//            } else {
//                $this->segmentsByNumberOfWords[$words][$actualString]++;
//            }
        }

        arsort($this->segmentsByNumberOfWords);

        return $this;
    }

    /**
     * @param int $numberOfWords
     * @return Phrases_Analysis|null
     * @deprecated
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
     * @deprecated
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