<?php
// Confirm email after registration
require_once "../bootstrap.php";

use \RedBeanPHP\R as R;

$user_name = $_GET['name'];
$user_key = $_GET['key'];
$user = R::findOne('users', 'name = ?', array("$user_name"));
$user->key = $user_key;

$_SESSION['logged_user'] = $user;

R::store($user);
header('Location:/');