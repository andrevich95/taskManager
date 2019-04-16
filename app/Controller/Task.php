<?php

namespace App\Controller;


use App\Model\Query\TaskQuery;
use App\Model\TaskModel;
use Core\ControllerAbstract;
use Core\Database\PDOConnection;

class Task extends ControllerAbstract
{
    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function actionIndex(){
        $connection = PDOConnection::getConnection('default');

        $taskQuery = new TaskQuery();

        $taskModel = new TaskModel($taskQuery);
        $tasks = $taskModel->fetchAll();

        $this->render('/task/list', [
            'tasks' => $tasks
        ]);
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function actionForm(){
        $id = $this->request()->paramsGet()['id'];

        $task = null;
        if(!is_null($id)){
            $taskQuery = new TaskQuery();

            $taskModel = new TaskModel($taskQuery);
            $task = $taskModel->fetchOne($id);
        }

        $this->render('/task/form',[
            'task' => $task
        ]);
    }

    /**
     * @throws \Exception
     */
    public function actionSave(){
        $params = $this->request()->paramsPost();

        $taskQuery = new TaskQuery();

        $taskModel = new TaskModel($taskQuery);
        $taskModel->map($params)->save();

        $this->response()->redirect('/list');
    }
}