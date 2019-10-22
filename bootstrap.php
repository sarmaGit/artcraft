<?php

require "vendor/autoload.php";
require_once "db_con.php";

use \RedBeanPHP\R as R;

R::setup($dsn, $user, $pswd);

session_start();
