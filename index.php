<?php

require __DIR__ . '/vendor/autoload.php';

use CoffeeCode\Router\Router;

$router = new Router(CONF_URL_TEST);

/*
 * Controllers
 */
$router->namespace("Source\App");


/*
 * WEB
 * home
 */
$router->group(null);
$router->get("/", "Web:home");
$router->post("/text_analyze", "Web:textAnalyze");
$router->post("/addBlackList", "Web:addBlacklist", "add.blacklist");
$router->get("/blackList", "Web:blackList", "show.blacklist");
$router->post("/deleteBlackList", "Web:deleteBlackList", "delete.blacklist");
$router->get("/exportCSV", "Web:exportExcel", "export.CSV");


/*
 * ERROS
 */
$router->group("ooops");
$router->get("/{errcode}", "Web:error");


/*
 * Executa as rotas
 */
$router->dispatch();


/*
 * Tratamento de erros de rotas
 */
if ($router->error()) {
    $router->redirect("/ooops/{$router->error()}");
}