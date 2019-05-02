<?php

require_once 'app/bootstrap.php';

$router = new \Core\Router();

try{
    /** Section with Auth Controller */
    $router->map('GET', '/login', new \Core\Http\Route('auth','login'));
    $router->map('POST', '/login', new \Core\Http\Route('auth','auth'));
    $router->map('GET', '/logout', new \Core\Http\Route('auth','logout'));

    /** Section with Task Controller */
    $router->map('GET', '/', new \Core\Http\Route('task','index'));
    $router->map('GET', '/list', new \Core\Http\Route('task','index'));
    $router->map('GET', '/task', new \Core\Http\Route('task','form'));
    $router->map('GET', '/done', new \Core\Http\Route('task','done'));
    $router->map('POST', '/task', new \Core\Http\Route('task','save'));

    \Core\Http\DispatcherAbstract::dispatch($router, 'web');
} catch (Exception $e){
    echo '<h1>Exception ' . $e->getCode() . '</h1><span>' . $e->getMessage() . '.</span>' .
        '<b>Stack trace</b>' . $e->getTraceAsString();
}
