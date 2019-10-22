<?php

require_once "bootstrap.php";
require_once "./includes/header.php";

?>
<?php if (isset($_SESSION['logged_user']) && !isset($_SESSION['logged_user']->key)): ?>
    <p class='alert alert-success'>Привет, <?php echo $_SESSION['logged_user']->name ?></p>
    <p class='alert alert-danger'>Ваш email еще не подтвержден</p>
    <p><a href="logout.php">Выйти</a></p>
<?php elseif (isset($_SESSION['logged_user']->key)): ?>
    <p class='alert alert-success'>Привет, <?php echo $_SESSION['logged_user']->name ?>!
        Доступ к <a href="">API</a></p>
    <p><a href="logout.php">Выйти</a></p>

    <table class="table table-striped">
        <thead class="thead-dark">
        <tr>
            <th><a href="/">Id</a></th>
            <th><a href="?order=name">Имя</a></th>
            <th><a href="?order=email">Email</a></th>
        </tr>
        </thead>
        <?php
        $u_help = new UserHelper();

        $order = $_GET['order'];

        $users = $u_help->users_order_by($order);
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['name']}</td>";
            echo "<td>{$user['email']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
<?php else: ?>
    <p><a href="register.php">Регистрация</a></p>
    <p><a href="login.php">Войти</a></p>

<?php endif; ?>

<?php
require_once "./includes/footer.php";
?>
