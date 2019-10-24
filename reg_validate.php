<?php
require_once "bootstrap.php";
require_once "./includes/header.php";
require_once "vendor/dapphp/securimage/securimage.php";

use \RedBeanPHP\R as R;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use \Firebase\JWT\JWT;

$data = $_POST;

$errors = array();

// Submit clicked
if (isset($data['do_reg'])) {
    // validate name
    if (trim($data['name'] == '')) {
        $errors[] = 'Введите ваше имя';
    }
    // validate email
    if (trim($data['email'] == '')) {
        $errors[] = 'Введите email';
    }
    // check unique email
    if (R::count('users', "email = ?", array($data['email'])) > 0) {
        $errors[] = 'Пользователь с таким email уже существует';
    }

    // Captcha validate

    $image = new Securimage();
    if (!$image->check($_POST['captcha_code']) == true) {
        $errors[] = 'Неверно набрана captcha';
    }

    if (empty($errors)) {
        // Success registration
        $user = R::dispense('users');
        $user->name = $data['name'];
        $user->email = $data['email'];

        // Generate key for confirm email

        $time = time();
        $token = array(
            "name" => $data['name'],
            "created_at" => $time,
            "expired_at" => $time + 3600
        );
        $jwt = JWT::encode($token, $api_key);

        // email subject
        $subj = "Confirm email";
        // email message
        $msg = "http://artcraft/confirm.php?key={$jwt}&name={$user->name}";

        //Create a new PHPMailer instance
        $mail = new PHPMailer;
        try {
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'html';
            //Set the hostname of the mail server
            $mail->Host = 'smtp.gmail.com';
            //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
            $mail->Port = 587;
            //Set the encryption system to use - ssl (deprecated) or tls
            $mail->SMTPSecure = 'tls';
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication - use full email address for gmail
            $mail->Username = "sarmatest69@gmail.com";
            //Password to use for SMTP authentication
            $mail->Password = "tGGWUNOS1";
            $mail->setFrom('from@example.com', 'Mailer');
            //Set who the message is to be sent to
            $mail->addAddress($user->email);
            $mail->isHTML(true);
            //Set the subject line
            $mail->Subject = $subj;
            $mail->Body = $msg;
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // store user without key
        R::store($user);
        echo "<div>
            <p class='alert alert-success'>Регистрация прошла успешно, подтвердите email.</p>
            <p><a href='/'>Главная</a></p>
              </div>";
    } else {
        // Display errors
        echo "<div>";
        foreach ($errors as $error) {
            echo "<p class='alert alert-danger'>{$error}</p>";
        }
        echo "</div>";
    }
}