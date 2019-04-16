<?php

namespace App\Model;

use App\Model\Query\UserQuery;
use Core\ModelAbstract;

class UserModel extends ModelAbstract{

    /** @var array */
    private $_data;

    /**
     * UserModel constructor.
     * @param UserQuery $query
     */
    public function __construct(UserQuery $query){
        $this->setQuery($query);
        $this->_data = [];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function fetchOne($id){
        return $this->getQuery()->findOne($id);
    }

    /**
     * @param $name
     * @return mixed
     */
    public function fetchOneByName($name){
        /** @var UserQuery $query */
        $query = $this->getQuery();
        return $query->findByCriteria(['Name' => $name]);
    }

    /**
     * @param $session
     * @return mixed
     */
    public function fetchOneBySession($session){
        /** @var UserQuery $query */
        $query = $this->getQuery();
        return $query->findByCriteria(['Session' => $session]);
    }

    /**
     * @return mixed
     */
    protected function resetQuery()
    {
        // TODO: Implement resetQuery() method.
    }

    /**
     * @param $data
     * @return $this|mixed
     * @throws \Exception
     */
    public function map($data)
    {
        if (isset($data['name'])) {
            $this->_data['Name'] = trim(htmlspecialchars($data['name']));
        }

        if (isset($data['password'])){
            $this->_data['Password'] = trim(htmlspecialchars($data['password']));
        }

        $date = new \DateTime('now');
        $this->_data['ExpiredTime'] = $date->format('Y-m-d H:i:s');

        $this->_data['Session'] = $this->generateHash();

        return $this;
    }

    /**
     * @return array
     */
    public function getData(){
        return $this->_data;
    }

    /**
     * @return mixed
     */
    public function save()
    {
        // TODO: Implement save() method.
    }

    /**
     * @return mixed
     */
    public function update()
    {
        $query = $this->getQuery();
        $where = ['Name' => $this->_data['Name']];

        unset($this->_data['Name']);
        unset($this->_data['Password']);

        $query->update(null, $this->_data, $where);
    }

    /**
     * @return string
     */
    private function generateHash(){
        return md5(uniqid());
    }
}