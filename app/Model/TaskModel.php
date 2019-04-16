<?php

namespace App\Model;

use App\Model\Query\TaskQuery;
use Core\ModelAbstract;

class TaskModel extends ModelAbstract {

    /** @var integer */
    private $_id;

    /** @var array */
    private $_data;

    /**
     * TaskModel constructor.
     * @param TaskQuery $query
     */
    public function __construct(TaskQuery $query){
        $this->setQuery($query);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchOne($id){
        return $this->getQuery()->findOne($id);
    }

    /**
     * @return mixed
     */
    public function fetchAll(){
        return $this->getQuery()->findAll();
    }

    /**
     * @param $params
     * @return $this|mixed
     */
    public function map($params){
        $validData = [];

        if (isset($params['id']) && !empty($params['id'])){
            $this->_id = intval(trim(htmlspecialchars($params['id'])));
        }

        if (isset($params['name'])){
            $validData['Name'] = trim(htmlspecialchars($params['name']));
        }

        if (isset($params['email'])){
            $validData['Email'] = trim(htmlspecialchars($params['email']));
        }

        if (isset($params['status'])){
            $validData['Status'] = boolval($params['status']);
        }

        if (isset($params['description'])){
            $validData['Description'] = trim(htmlspecialchars($params['description']));
        }

        $this->_data = $validData;

        return $this;
    }


    /**
     * @return int
     * @throws \Exception
     */
    public function count(){
        $query = $this->resetQuery();
        return $query->count();
    }

    /**
     * @return mixed
     */
    public function save(){
        if(!is_null($this->_id)){
            $this->update();
        } else{
            $query = $this->getQuery();

            $query->insert(null, $this->_data);
        }

        return true;
    }

    /**
     * @return mixed|void
     */
    public function update()
    {
        $query = $this->getQuery();
        $where = ['ID' => $this->_id];

        $query->update(null, $this->_data, $where);
    }

    /**
     * @return TaskQuery|mixed
     * @throws \Exception
     */
    protected function resetQuery()
    {
        return new TaskQuery();
    }
}