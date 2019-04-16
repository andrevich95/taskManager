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

    public function __construct(){

    }

    /**
     * @param $hash
     * @throws \Exception
     */
    public static function getSessionUser($hash){
        $qb = PDOConnection::getConnection('default');


    }
}