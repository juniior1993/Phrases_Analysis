<?php


namespace Source\App;

use League\Plates\Engine;

class Web
{

    private $view;

    public function __construct()
    {
        $this->view = Engine::create(__DIR__ . '/../../theme/pages', "php");
    }

    public function home($data)
    {
        echo $this->view->render("analyze_words", [
            "title" => "Analisar Frases"
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