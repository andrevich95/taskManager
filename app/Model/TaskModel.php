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

        if (isset($params['id'])){
            $this->_id = intval(trim(htmlspecialchars($params['id'])));
        }

        if (isset($params['name'])){
            $validData['Name'] = trim(htmlspecialchars($params['name']));
        }

        if (isset($params['email'])){
            $validData['Email'] = trim(htmlspecialchars($params['email']));
        }

        if (isset($params['status'])){
            $validData['Status'] = trim(htmlspecialchars($params['status']));
        }

        if (isset($params['description'])){
            $validData['Description'] = trim(htmlspecialchars($params['description']));
        }

        $this->_data = $validData;

        return $this;
    }

    /**
     * @return mixed
     */
    public function save(){
        $query = $this->getQuery();

        $query->insert(null, $this->_data);
    }

    /**
     * @return mixed|void
     */
    public function update()
    {
        $query = $this->getQuery();

        $query->update(null, $this->_data, $this->_id);
    }
}