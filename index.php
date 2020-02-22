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