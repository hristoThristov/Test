<?php
/**
 * @file
 *  File containing navigation.
 */
?>

<nav class="navigation">
    <a href="index.php">Начало</a>
    <?php if(!isLoggedIn()) { ?>
    <a href="register.php">Регистрация</a>
    <a href="login.php">Вход</a>
    <?php } else { ?>
    <a href="create-page.php">Добави страница</a>
    <a href="logout.php">Изход</a>
    <?php } ?>
</nav>