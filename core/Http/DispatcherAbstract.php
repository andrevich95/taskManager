<?php

namespace Core\Http;

use Core\Router;

abstract class DispatcherAbstract{

    /** @var Router  */
    protected $_router;

    public function __construct(Router $router) {
        $this->_router = $router;
    }

    /**
     * @param Router $router
     * @param $method
     * @throws \ReflectionException
     * @throws \Exception
     */
    public static function dispatch(Router $router, $method){
        $request = new Request();
        $response = new Response();

        $method = ucfirst(strtolower($method));
        $class = "\\App\\Infrastructure\\Dispatcher\\{$method}";

        $rf = new \ReflectionClass($class);
        /** @var static $instance */
        $instance = $rf->newInstance($router);
        $instance->execute($request, $response);
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return mixed
     */
    protected abstract function execute($request, $response);

}