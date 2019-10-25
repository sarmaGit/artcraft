<?php
require_once "../bootstrap.php";
require_once "../includes/header.php";
require_once "../vendor/dapphp/securimage/securimage.php";

$data = $_POST;

// Submit clicked
if (isset($data['do_reg'])) {
    $validator = new Validator();
    $validator->validate_name($data['name']);
    $validator->validate_email($data['email']);
    $image = new Securimage();
    $validator->validate_captcha($image);

    if (empty($validator->get_errors())) {
        // Success registration
        User::create_user($data, $api_key);
        echo "<div>
            <p class='alert alert-success'>Регистрация прошла успешно, подтвердите email.</p>
            <p><a href='/'>Главная</a></p>
              </div>";
    } else {
        // Display errors
        $validator->display_errors();
    }
}


?>
<form action="/app/register.php" method="POST">
    <div style="color:red" id="errors"></div>
    <div class="form-group">
        <label for="name">Введите ваше имя:</label>
        <p><input type="text" class="form-control js-validate" name="name" id="name"
                  value="<?php echo @$data['name'] ?>"></p>
    </div>

    <div class="form-group">
        <label for="email">Введите ваш e-mail:</label>
        <p><input type="email" class="form-control js-validate" name="email" id="email"
                  value="<?php echo @$data['email'] ?>"></p>
    </div>

    <?php
    echo Securimage::getCaptchaHtml();
    ?>

    <button type="submit" name="do_reg" id="registration">Зарегистрироваться</button>
</form>
<script src="../js/lib.js"></script>