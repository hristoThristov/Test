<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('html_errors', TRUE);

$to = "hristo@example.com";	// До кой мейл адрес изпращаме e-mail-a
$subject = "My subject"; 	// Тема
$headers = "From: webmaster@example.com" . "\r\n" . // E-mail на подателя
"CC: somebodyelse@example.com\r\n"; // Carbon copy
$headers .= "MIME-Version: 1.0\r\n"; // MIME type
$headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // Content-Type посочващ, че писмото ще съдържа HTML.

$txt = "<h1>Hello world!</h1>";
$txt .= "<h1>My first e-mail!!!</h1>";
$txt .= "<p>
	<ul>
		<li>List item 1</li>
		<li>List item 2</li>
		<li>List item 3</li>
		<li>List item 4</li>
	</ul>
</p>"; // Текст на съобщението

$sent = mail($to, $subject, $txt, $headers);

var_dump($sent);
?>