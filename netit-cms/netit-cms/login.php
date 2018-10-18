<?php
/**
 * @file
 *  Login file
 */
session_start();

include "./config/config.php";
include "./functions/common.php";
include "./src/User.class.php";

if(isLoggedIn()) {
    header("Location: index.php");
}

$errMsg = "";

if(!empty($_POST)) {
	$user = new User();
	$loaded = $user->loadUser($pdo, 'username', $_POST['username']);

    if(!empty($loaded)) {
        if($user->checkPassword($_POST['password'])) {
            $_SESSION['user'] = $user;
            header("Location: index.php");
        }
        else {
            $errMsg = "Credentials do not match.";
        }
	}
	else {
		$errMsg = "User could not be loaded.";
	}

	unset($user);
}

?>
<!DOCTYPE html>
<html>
	<?php
		include "./partials/header.php";
	?>
	<body class="page page-logreg">
		<h1 class="page-title">Вход</h1>
		<?php
			include "./partials/navigation.php";
		?>
        <?php
			showMessages($errMsg);
		?>
		<form action="#" method="POST" name="login">
			<label for="reg-username">Потребителско име</label>
			<input id="reg-username" type="email" name="username" placeholder="E-mail" required />
			<label for="reg-password">Парола</label>
			<input id="reg-password" type="password" name="password" placeholder="Парола" required />
			<input type="submit" name="submit" value="Вход" class="button logreg" />
		</form>
	</body>
</html>