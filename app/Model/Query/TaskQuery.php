<?php

namespace App\Model\Query;

use Core\Database\QueryAbstract;

class TaskQuery extends QueryAbstract{

    public function __construct()
    {
        parent::__construct();

        $this->from('task');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findOne($id)
    {
        $task = $this->fetchOne($id);

        $data = [
            'ID' => $task['ID'],
            'Name' => $task['Name'],
            'Email' => $task['Email'],
            'Description' => $task['Description'],
            'Status' => boolval($task['Status'])
        ];

        return $data;
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $tasks = $this->fetchAll();

        $data = [];

        foreach ($tasks as $task){
            $data[] = [
                'ID' => $task['ID'],
                'Name' => $task['Name'],
                'Email' => $task['Email'],
                'Description' => $task['Description'],
                'Status' => boolval($task['Status'])
            ];
        }

        return $data;
    }
}