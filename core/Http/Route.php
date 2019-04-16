<?php

namespace Core\Http;

class Route{

    /** @var string */
    private $_action;

    /** @var string */
    private $_controller;

    /** @var bool */
    private $_private;

    public function __construct($controller, $action, $private = false){
        $this->_action = $action;
        $this->_controller = $controller;
        $this->_private = $private;
    }

    /**
     * @return string
     */
    public function controller(){
        return ucfirst($this->_controller);
    }

    /**
     * @return string
     */
    public function action(){
        return ucfirst($this->_action);
    }

}