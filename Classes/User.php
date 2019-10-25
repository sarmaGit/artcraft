<?php

use \RedBeanPHP\R as R;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use \Firebase\JWT\JWT;


class User
{

    public static function create_user($data,$api_key){
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
        $msg = "http://".$_SERVER['HTTP_HOST']."/app/confirm.php?key={$jwt}&name={$user->name}";

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
    }

    public static function refresh_key($api_key){
        $key = $_SESSION['logged_user']->key;
        $token_decoded = JWT::decode($key, $api_key, array('HS256'));
        if ($token_decoded->expired_at < time()) {
            $token_decoded->expired_at +=time() + 3600;
            $token = JWT::encode($token_decoded, $api_key);
            $logged_user = $_SESSION['logged_user'];
            $logged_user->key = $token;
            R::store($logged_user);
        }
    }

}