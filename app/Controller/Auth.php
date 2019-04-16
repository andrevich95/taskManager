<?php

namespace App\Controller;

use App\Model\Query\UserQuery;
use App\Model\UserModel;
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
        $this->request()->unsetCookie();
        $this->response()->redirect('/');
    }

    /**
     * @throws \Exception
     */
    public function actionAuth(){
        $data = $this->request()->paramsPost();

        $userQuery = new UserQuery();

        $userModel = new UserModel($userQuery);
        $userModel->map($data);

        $userData = $userModel->getData();

        $user = $userModel->fetchOneByName($userData['Name']);

        if(password_verify($userData['Password'], $user['Password'])){
            $userModel->update();
            $this->request()->setCookie($userData['Session']);
        }

        $this->response()->redirect('/');
    }
}