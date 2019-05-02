<?php

namespace App\Infrastructure\Dispatcher;

use App\Controller\Service;
use App\Model\Query\UserQuery;
use App\Model\UserModel;
use Core\ControllerAbstract;
use Core\Http\DispatcherAbstract;
use Core\Http;

class Web extends DispatcherAbstract
{

    /**
     * @param Http\Request $request
     * @param Http\Response $response
     * @return mixed|void
     * @throws \ReflectionException
     * @throws \Exception
     */
    protected function execute($request, $response)
    {
        /** @var Http\Route $currentRoute */
        $currentRoute = $this->_router->get($request->url(), $request->method());

        $user = self::authenticate($request);

        if (!is_null($user)) {
            $request->setUser($user);
        }

        if (is_null($currentRoute)) {
            $service = new Service($request, $response);
            $service->actionNotFound();
            $response->send();
        } else {
            $controller = $currentRoute->controller();
            $act = 'action' . $currentRoute->action();

            /** @var \ReflectionClass $rf */
            $rf = new \ReflectionClass("App\\Controller\\{$controller}");

            /** @var ControllerAbstract $controller */
            $controller = $rf->newInstance($request, $response);

            $controller->$act();
            $response->send();
        }
    }


    /**
     * @param Http\Request $request
     * @return |null
     * @throws \Exception
     */
    private static function authenticate(Http\Request $request)
    {
        $session = $request->getCookie();

        if (is_null($session))
            return null;
        $userQuery = new UserQuery();

        $userModel = new UserModel($userQuery);
        $user = $userModel->fetchOneBySession($session);

        if (!is_null($user)) {
            return Http\User::create($user);
        }

        return null;
    }
}