<?php

namespace App\Model\Query;

use Core\Database\QueryAbstract;

class UserQuery extends QueryAbstract{

    /**
     * UserQuery constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        parent::__construct();

        $this->from('user');
    }

    /**
     * @param $id
     * @return array|mixed
     * @throws \Exception
     */
    public function findOne($id)
    {
        $user = $this->fetchOne($id);

        $data = [
            'ID' => $user['ID'],
            'Name' => $user['Name'],
            'Session' => $user['Session'],
            'Password' => $user['Password'],
            'ExpiredTime' => new \DateTime($user['ExpiredTime'])
        ];

        return $data;
    }

    /**
     * @param $where
     * @return mixed
     */
    public function findByCriteria($where){
        foreach ($where as $key => $value){
            $this->where($key, $value);
        }
        return $this->fetchOneCriteria();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        // TODO: Implement findAll() method.
    }

    /**
     * @return mixed
     */
    public function count()
    {
        // TODO: Implement count() method.
    }
}