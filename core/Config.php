<?php

namespace Core;

class Config{

    /** @var array */
    static $data;

    /**
     * @param $value
     */
    public static function set($value){
        self::$data = $value;
    }

    /**
     * @param $key
     * @return mixed
     * @throws \Exception
     */
    public static function get($key){
        if(array_key_exists($key, self::$data)){
            return self::$data[$key];
        } else{
            throw new \Exception('No such config found');
        }
    }
}