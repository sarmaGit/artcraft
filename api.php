<?php
require_once "bootstrap.php";

use \RedBeanPHP\R;
use Spatie\ArrayToXml\ArrayToXml;
use \Firebase\JWT\JWT;


$key = $_GET['key'];
$file_type = $_GET['type'];
if (isset($key)) {
    $user = R::findOne('users', '`key` = ?', array($key));
    if ($user) {
        $token_decoded = JWT::decode($key, $api_key, array('HS256'));
        if ($token_decoded->expired_at > time()) {
            $users = R::getAll("select * from users");
            switch ($file_type) {
                case "json":
                    header('Content-type:application/json;charset=utf-8');
                    echo json_encode($users);
                    break;
                case "xml":
                    header('Content-type:text/xml;charset=utf-8');
                    $xml = ArrayToXml::convert(['user' => $users]);
                    echo $xml;
                    break;
                default:
                    header('Content-type:application/json;charset=utf-8');
                    echo json_encode($users);
                    break;
            }
        }else {
            header('HTTP/1.0 403 Forbidden');
        }
    } else {
        header('HTTP/1.0 403 Forbidden');
    }
} else {
    header('HTTP/1.0 403 Forbidden');
}
