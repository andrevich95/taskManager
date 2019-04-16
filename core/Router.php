<?php

namespace Core;

use Core\Http\Method;
use Core\Http\Route;

class Router{

    /** @var array */
    private $routes;

    public function __construct(){
        $this->routes = [];
    }

    /**
     * We need type to check if route is for private users
     * @param $method
     * @param $url
     * @param $route
     * @param bool $type
     * @throws \Exception
     */
    public function map($method, $url, Route $route, $type = false){
        if(array_key_exists($url, $this->routes)){
            throw new \Exception('Such route is already exists');
        }
        $this->routes[] = [
            'url' => $url,
            'method' => $method,
            'route' => $route,
            'type' => $type
        ];
    }

    /**
     * @param $url
     * @param string $method
     * @return mixed
     */
    public function get($url, $method = 'GET'){
        foreach ($this->routes as $route){
            if($route['url'] === $url && $route['method'] === $method){
                return $route['route'];
            }
        }
        return null;
    }
}