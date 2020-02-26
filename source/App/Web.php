<?php


namespace Source\App;

use League\Plates\Engine;
use Source\Core\Phrases_Analysis;
use Source\Models\BlackList;

class Web
{

    /** @var Engine */
    private Engine $view;

    public function __construct($router)
    {
        $this->view = Engine::create(__DIR__ . '/../../theme/pages', "php");

        $this->view->addData(["router" => $router]);
    }

    public function home($data)
    {
        echo $this->view->render("analyze_words", [
            "title" => "Analisar Frases"
        ]);
    }


    public function textAnalyze(array $data): void
    {
        $text = trim(filter_var($data['textToAnalyze'], FILTER_SANITIZE_STRING));
        $caseSensitive = false;
        if (isset($data['caseSensitive'])) {
            $caseSensitive = true;
        }

        $analysis = new Phrases_Analysis();
        $analysis->caseSensitive($caseSensitive)
            ->setText($text)
            ->getWordsAndSplit($text)
            ->setMinWords($data['wordsToAnalyze'])
            ->setMinRepetitions($data['wordsToShow'])
            ->analyze()
            ->getUniqueNumberOfRepetitionsAndWords();


        echo $this->view->render("analyzed_text", [
            "title" => "Resultado da analize",
            "phrases" => $analysis->segmentsAndRepetitions,
            "filterWords" => $analysis->uniqueNumberOfWords,
            "filterRepetitions" => $analysis->uniqueNumberOfRepetitions
        ]);


    }

    public function addBlacklist(array $data): void
    {

        $blackList = new BlackList();
        $blackList->setSegment($data['segment']);
        $callbalck["concluido"] = $blackList->addBlackList();
        echo json_encode($callbalck);
    }

    public function deleteBlackList($data)
    {
        $blackList = new BlackList();
        echo json_encode($blackList->deleteSegment($data['segment']));
    }


    public function blackList(array $data): void
    {
        $blackList = (new BlackList())->showAll();
        echo $this->view->render("show_black_list", [
            "title" => "Black List",
            "blacklist" => $blackList
        ]);
    }


    public function error($data)
    {
        echo $this->view->render("error", [
            "title" => "Erro {$data['errcode']}",
            "error" => $data['errcode']
        ]);
    }
}