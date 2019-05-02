<?php

namespace App\Controller;


use App\Model\Query\TaskQuery;
use App\Model\TaskModel;
use Core\ControllerAbstract;
use Core\Database\PDOConnection;

class Task extends ControllerAbstract
{

    const LIMIT_PER_PAGE = 3;

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
     */
    public function actionIndex(){
        $page = $this->request()->paramsGet()['page'];
        $order = $this->request()->paramsGet()['order'];
        $type = $this->request()->paramsGet()['type'];

        $type = empty($type) ? 'ASC' : $type;

        $offset = empty($page) ? 0 : (intval($page) - 1)  * self::LIMIT_PER_PAGE;

        $taskQuery = new TaskQuery();

        $taskQuery->limit(self::LIMIT_PER_PAGE);
        $taskQuery->offset($offset);

        if(!empty($order)){
            $taskQuery->order($order, $type);
        }

        $taskModel = new TaskModel($taskQuery);
        $tasks = $taskModel->fetchAll();

        $pages = ceil($taskModel->count() / self::LIMIT_PER_PAGE);

        $this->render('/task/list', [
            'tasks' => $tasks,
            'pages' => $pages,
            'order' => $order,
            'page' => $page,
            'type' => $type
        ]);
    }

    /**
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     * @throws \Exception
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

    /**
     * @throws \Exception
     */
    public function actionDone(){
        $data = $this->request()->paramsGet();

        $params = ['id' => $data['id'], 'status' => true];

        $taskQuery = new TaskQuery();

        $taskModel = new TaskModel($taskQuery);
        $taskModel->map($params)->update();

        $this->response()->redirect('/list');
    }

    /**
     * @param $type
     * @return string
     */
    private function opositeType($type){
        return $type === 'ASC' ? 'DESC' : 'ASC';
    }
}