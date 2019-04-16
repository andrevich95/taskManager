<?php

namespace Core\Http;

use App\Controller\Service;
use App\Model\Query\UserQuery;
use App\Model\UserModel;
use Core\ControllerAbstract;
use Core\Router;

class Dispatcher{

    /**
     * @param Router $router
     * @throws \ReflectionException
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public static function dispatch(Router $router){
        $request = new Request();
        $response = new Response();
        /** @var Route $currentRoute */
        $currentRoute = $router->get($request->url(), $request->method());

        $user = self::authenticate($request);

        if(!is_null($user)){
            $request->setUser($user);
        }

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

    /**
     * @param Request $request
     * @return User|null
     * @throws \Exception
     */
    private static function authenticate(Request $request){
        $session = $request->getCookie();

        if(is_null($session))
            return null;
        $userQuery = new UserQuery();

        $userModel = new UserModel($userQuery);
        $user = $userModel->fetchOneBySession($session);

        if(!is_null($user)){
            return User::create($user);
        }

        return null;
    }
}