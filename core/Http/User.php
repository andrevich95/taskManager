<?php

namespace Core\Http;

use Core\Database\PDOConnection;

class User{

    /** @var integer */
    private $_id;

    /** @var string */
    private $_name;

    /** @var string */
    private $_session;

    /**
     * @return int
     */
    public function id()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->_name;
    }

    /**
     * @return string
     */
    public function session()
    {
        return $this->_session;
    }

    /**
     * User constructor.
     */
    public function __construct(){

    }

    /**
     * @param array $data
     * @return User
     */
    public static function create($data){
        $obj = new static();
        $obj->_id = $data['ID'];
        $obj->_session = $data['Session'];
        $obj->_name = $data['Name'];

        return $obj;
    }


}