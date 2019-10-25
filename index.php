<?php

require_once "bootstrap.php";
require_once "./includes/header.php";

//echo $_SERVER['REQUEST_URI'];

?>
<?php if (isset($_SESSION['logged_user']) && !isset($_SESSION['logged_user']->key)): ?>
    <p class='alert alert-success'>Привет, <?php echo $_SESSION['logged_user']->name ?></p>
    <p class='alert alert-danger'>Ваш email еще не подтвержден</p>
    <p><a href="app/logout.php">Выйти</a></p>
<?php elseif (isset($_SESSION['logged_user']->key)): ?>
    <p class='alert alert-success'>Привет, <?php echo $_SESSION['logged_user']->name ?>!
        Доступ к <a href="/app/api.php?type=xml&key=<?php echo $_SESSION['logged_user']->key ?>">API</a></p>
    <p><a href="app/logout.php">Выйти</a></p>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th><a href="/">Id</a></th>
            <th><a href="?order=name">Имя</a></th>
            <th><a href="?order=email">Email</a></th>
        </tr>
        </thead>
        <?php

        $order = $_GET['order'];

        $users = Helper::order_by('users', $order);
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['name']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "</tr>";
        }

        User::refresh_key($api_key);

        ?>

    </table>
<?php else: ?>
    <p><a href="app/register.php">Регистрация</a></p>
    <p><a href="app/login.php">Войти</a></p>

<?php endif; ?>

<?php
require_once "./includes/footer.php";
?>
