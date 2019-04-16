<?php

namespace Core\Database;

use Core\Config;
use PDO;

class PDOConnection {

    /** @var \PDO|null */
    static $connection;

    /**
     * @param $name
     * @return \PDO
     * @throws \Exception
     */
    public static function getConnection($name){
        if (is_null(self::$connection)) {
            $settings = Config::get($name);

            $host = $settings['host'];
            $driver = $settings['driver'];
            $user = $settings['user'];
            $password = $settings['password'];
            $db = $settings['db'];

            $connection = new \PDO("{$driver}:host={$host};dbname={$db}", $user, $password);
            self::$connection = $connection;
        }

        return self::$connection;
    }

}