<?php

namespace App\Controller;


use Core\ControllerAbstract;

class Service extends ControllerAbstract{

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function actionNotFound(){
        $this->render('404',[
            'url' => $this->request()->url()
        ]);
    }
}