<?php

require_once "bootstrap.php";
require_once "./includes/header.php";

use \RedBeanPHP\R as R;

$data = $_POST;

$errors = array();

if (isset($data['do_login'])) {
    $user = R::findOne('users', 'name = ?', array($data['name']));
    if ($user) {
        //success sign_in
        $_SESSION['logged_user'] = $user;
        echo "<div><p class='alert alert-success'>
                {$user->name} успешно авторизованы, можете перейти на <a href='/'>главную</a> страницу
              </p></div>";
    } else {
        $errors[] = 'Пользователя с таким именем не существует';
    }
}
if (!empty($errors)) {
    //display errors
    echo "<div>";
    foreach ($errors as $error) {
        echo "<p class='alert alert-danger'>{$error}</p>";
    }
    echo "</div>";
}

?>

<form action="login.php" method="POST">
    <div class="form-group">
        <label for="name">Введите ваше имя:</label>
        <p><input type="text" class="form-control" id="name" name="name" value="<?php echo @$data['name'] ?>"></p>

        <button type="submit" name="do_login" class="btn btn-primary">Войти</button>
    </div>
</form>