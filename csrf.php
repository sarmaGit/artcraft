<?php
$key = "sarma_key";
$token = array(
    "id" => 1,
    "key_created_at" => "2019-10-22 21:06:00",
    "key_expire_at" => "2019-10-22 22:06:00"
);

$jwt = JWT::encode($token, $key);

setcookie('api_token', $jwt);


// API
// 1. Есть ли key в $_GET, если нет => нахер (return 403)
//2. Есть ли юзер по ключу, нет - 403
//3. JWT в базу при регистрации
//4. decode JWT смотрим expire_at, если в прошлом 403, если норм - АПИ

//HTML
//1. выводить JWT (index.php)
//2. если JWT просран - сгенерить новый и записать в БД и показать юзеру