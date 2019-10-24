<?php

require_once "bootstrap.php";

use \RedBeanPHP\R as R;

$data = $_POST;

$errors = array();

// validate name
if (trim($data['name'] == '')) {
    $errors[] = 'Введите ваше имя';
}
// validate email
if (trim($data['email'] == '')) {
    $errors[] = 'Введите email';
}

if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Неверный email';
}
// check unique email
if (R::count('users', "email = ?", array($data['email'])) > 0) {
    $errors[] = 'Пользователь с таким email уже существует';
}

$response = [];
if (empty($errors)) {
    echo json_encode($response = 1);
} else {
    echo json_encode($errors);
}
//var_dump($data);