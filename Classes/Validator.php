<?php

use \RedBeanPHP\R;

class Validator
{
    protected $_errors;

    public function get_errors(){
        return $this->_errors;
    }

    public function validate_name($name)
    {
        if (trim($name == '')) {
            $this->_errors[] = 'Введите ваше имя';
        }
    }

    public function validate_email($email)
    {
        // validate email if !empty
        if (trim($email == '')) {
            $this->_errors[] = 'Введите email';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_errors[] = 'Неверный email';
        }
        // check unique email
        if (R::count('users', "email = ?", array($email)) > 0) {
            $this->_errors[] = 'Пользователь с таким email уже существует';
        }
    }

    public function validate_captcha($image)
    {
        if (!$image->check($_POST['captcha_code']) == true) {
            $this->_errors[] = 'Неверно набрана captcha';
        }
    }

    public function display_errors(){
        echo "<div>";
        foreach ($this->_errors as $error) {
            echo "<p class='alert alert-danger'>{$error}</p>";
        }
        echo "</div>";
    }
}