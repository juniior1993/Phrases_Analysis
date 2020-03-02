<?php


namespace Source\App;


use League\Csv\Writer;
use League\Plates\Engine;
use Source\Core\Phrases_Analysis;
use Source\Models\BlackList;
use Source\Models\Session;

class Web
{

    /** @var Engine */
    private Engine $view;

    private Session $session;

    public function __construct($router)
    {
        session_start();
        $this->view = Engine::create(__DIR__ . '/../../theme/pages', "php");

        $this->view->addData(["router" => $router]);

        $this->session = new Session();
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
            ->getWordsAndSplit()
            ->setMinWords($data['wordsToAnalyze'])
            ->setMinRepetitions($data['wordsToShow'])
            ->analyze()
            ->getUniqueNumberOfRepetitionsAndWords();

        $this->session->setSession($analysis->segmentsAndRepetitions);

        echo $this->view->render("analyzed_text", [
            "title" => "Resultado da analize",
            "phrases" => $analysis->segmentsAndRepetitions,
            "filterWords" => $analysis->uniqueNumberOfWords,
            "filterRepetitions" => $analysis->uniqueNumberOfRepetitions
        ]);


    }

    public function exportExcel(array $data): void
    {
        if ($_SESSION['analyze']) {
            $csv = Writer::createFromString("");
            $csv->setDelimiter(";");
            $csv->insertOne([
                "Segmento",
                "Palavras",
                "Repetição"
            ]);

            foreach ($_SESSION['analyze'] as $repetition => $segments) {
                foreach ($segments as $segment => $words) {
                    if ($segment) {
                        $csv->insertOne([
                            $segment,
                            $words,
                            $repetition
                        ]);
                    }
                }
            }
            $csv->setOutputBOM(Writer::BOM_UTF8);
            $csv->addStreamFilter('convert.iconv.ISO-8859-15/UTF-8');

            $csv->output('export_segments.csv');
        }


    }

    public function addBlacklist(array $data): void
    {

        $blackList = new BlackList();
        $blackList->setSegment($data['segment']);

        if ($this->session->delete($data['repetition'], $data['segment'])) {
            $callbalck["concluido"] = $blackList->addBlackList();
            echo json_encode($callbalck);
        } else {
            echo json_encode(false);
        }


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