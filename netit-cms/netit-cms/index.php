<?php
/**
 * @file
 * 	Главен файл на системата.
 */
session_start();

include "./functions/common.php";

?>
<!DOCTYPE html>
<html>
	<?php
		include "./partials/header.php";
	?>
	<body class="page page-index">
		<h1 class="page-title">NetIt CMS</h1>
		<?php
			include "./partials/navigation.php";
		?>
	</body>
</html>