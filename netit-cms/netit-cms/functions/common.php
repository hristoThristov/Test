<?php
/**
 * @file
 * 	Файл за функции, които ще се изпозлват често в сайта.
 */

 /**
  * 
  */
function pre_dump($data) {
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
}

function showMessages($message) {
	if(!empty($message)) {
	?>
	<div class="message"><?php echo $message; ?></div>
	<?php
	}
}

function isLoggedIn() {
	if(!empty($_SESSION['user'])) {
		return TRUE;
	}

	return FALSE;
}

function printSelect(array $optionsArray) {
	if(!empty($optionsArray)) {
		foreach($optionsArray as $item) {
			echo "<option value='{$item}'>{$item}</option>";
		}
	}
}