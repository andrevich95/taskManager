<?php

$dir = dirname(__FILE__);
$dirPath = explode(DIRECTORY_SEPARATOR, $dir);

define('ROOT_DIR', implode(DIRECTORY_SEPARATOR, array_slice($dirPath , 0, count($dirPath) - 1)) . DIRECTORY_SEPARATOR);
define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR);

require_once ROOT_DIR . 'vendor/autoload.php';

Core\Config::set(require APP_DIR . 'config/config.php');