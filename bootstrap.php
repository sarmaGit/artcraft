<?php

require "vendor/autoload.php";

use \RedBeanPHP\R as R;

$config = parse_ini_file('.config.ini', true);

// костыль
$api_key = $config['api_key'];

R::setup($config['dsn'], $config['user'], $config['pswd']);

session_start();
