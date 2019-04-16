<?php

namespace Core;

use Core\Http;
use Twig;

abstract class ControllerAbstract {

    /** @var Http\Request */
    private $_request;

    /** @var Http\Response */
    private $_response;

    public function __construct(Http\Request $request, Http\Response $response){
        $this->_response = $response;
        $this->_request = $request;
    }

    /**
     * @param $view
     * @param $data
     * @throws Twig\Error\LoaderError
     * @throws Twig\Error\RuntimeError
     * @throws Twig\Error\SyntaxError
     */
    public function render($view, $data){
        $loader = new Twig\Loader\FilesystemLoader(APP_DIR . 'view');
        $twig = new Twig\Environment($loader,[
            //'cache' => APP_DIR . 'cache'
        ]);

        $body = $twig->render($view . '.html.twig', $data);

        $html = $twig->render('layout.html.twig',[
            'body' => $body
        ]);

        $this->_response->html($html);
    }

    /**
     * @return Http\Request
     */
    public function request(){
        return $this->_request;
    }

    /**
     * @return Http\Response
     */
    public function response(){
        return $this->_response;
    }
}