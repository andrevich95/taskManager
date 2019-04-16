<?php

namespace Core\Http;

use App\Controller\Service;
use Core\ControllerAbstract;
use Core\Router;

class Dispatcher{

    /**
     * @param Router $router
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public static function dispatch(Router $router){
        $request = new Request();
        $response = new Response();
        /** @var Route $currentRoute */
        $currentRoute = $router->get($request->url(), $request->method());

        if (is_null($currentRoute)){
            $service = new Service($request, $response);
            $service->actionNotFound();
            $response->send();
        } else{
            $controller = $currentRoute->controller();
            $act = 'action'.$currentRoute->action();

            /** @var \ReflectionClass $rf */
            $rf = new \ReflectionClass("App\\Controller\\{$controller}");

            /** @var ControllerAbstract $controller */
            $controller = $rf->newInstance($request, $response);

            $controller->$act();
            $response->send();
        }
    }
}