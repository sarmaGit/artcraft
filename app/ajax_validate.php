<?php

require_once "../bootstrap.php";

$data = $_POST;

$validator = new Validator();

$validator->validate_name($data['name']);

$validator->validate_email($data['email']);

$response = [];
if (empty($validator->get_errors())) {
    echo json_encode($response = 1);
} else {
    echo json_encode($validator->get_errors());
}