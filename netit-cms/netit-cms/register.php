<?php
/**
 * @file
 * 	Файл за регистрационна форма и обработка на регистрацията.
 */
session_start();

include "./config/config.php";
include "./functions/common.php";
include "./src/User.class.php";

if(isLoggedIn()) {
    header("Location: index.php");
}

$errMsg = "";

if(		!empty($_POST['password'])
	&& 	!empty($_POST['repeat_password'])
	&&	$_POST['password'] == $_POST['repeat_password'])
{
	$user = new User(NULL, $_POST['username'], $_POST['password'], $_POST['phone'], $_POST['birth_date']);
	$errMsg = $user->insert($pdo);

	if(!empty($user->id)) {
		$_SESSION['user'] = $user;
		header("Location: index.php");
	}
}
else if (	!empty($_POST['password'])
		&& 	!empty($_POST['repeat_password'])
		&&	$_POST['password'] != $_POST['repeat_password']) {
	$errMsg = "The password should match.";
}

?>
<!DOCTYPE html>
<html>
	<?php
		include "./partials/header.php";
	?>
	<body class="page page-logreg">
		<h1 class="page-title">Регистрация</h1>
		<?php
			include "./partials/navigation.php";
		?>
		<?php
			showMessages($errMsg);
		?>
		<form action="#" method="POST" name="registration">
			<label for="reg-username">Потребителско име</label>
			<input id="reg-username" type="email" name="username" placeholder="E-mail" required />
			<label for="reg-password">Парола</label>
			<input id="reg-password" type="password" name="password" placeholder="Парола" required />
			<label for="reg-rep-pass">Повторете паролата</label>
			<input id="reg-rep-pass" type="password" name="repeat_password" placeholder="Повторете паролата" required />
			<label for="reg-phone">Телефон</label>
			<input id="reg-phone" type="phone" name="phone" placeholder="Телефон" requierd />
			<label for="reg-birth-date">Дата на раждане</label>
			<input id="reg-birth-date" type="date" name="birth_date" reqired />
			<input type="submit" name="submit" value="Регистрация" class="button register" />
		</form>
	</body>
</html>