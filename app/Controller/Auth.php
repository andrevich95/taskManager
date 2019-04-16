<?php

namespace App\Controller;

use Core\ControllerAbstract;

class Auth extends ControllerAbstract{

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function actionLogin(){
        $this->render('/login',[

        ]);
    }

    public function actionLogout(){

    }

    public function actionAuth(){
        $data = $this->request()->paramsPost();

    }
}