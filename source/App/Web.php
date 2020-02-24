<?php


namespace Source\App;

use League\Plates\Engine;
use Source\Core\Phrases_Analysis;
use Source\Models\BlackList;

class Web
{

    private $view;

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


    public function textAnalyze($data)
    {
        $text = trim(filter_var($data['textToAnalyze'], FILTER_SANITIZE_STRING));
        $analysis = new Phrases_Analysis();
        $analysis->setText($text);
        $analysis->getWordsAndSplit($text);
        $analysis->setMinWords($data['wordsToAnalyze']);
        $analysis->setMinRepetitions($data['wordsToShow']);
        $analysis->analyze();

        echo $this->view->render("analyzed_text", [
            "title" => "Resultado da analize",
            "phrases" => $analysis->segmentsAndRepetitions
        ]);
    }

    public function addBlacklist($data)
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



    public function blackList()
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