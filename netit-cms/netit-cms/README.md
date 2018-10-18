# Пускане на проекта

## Инициализиране на база данни

Създайте нова база данни с име `netitcms` и импортирайте `netitcms.sql` файла ор папката `db`.

## Конфигурация

Създайте папка `config`, а в нея файл `config.php` със следното съдържание:

```
<?php
/*
	Конфигурационен файл само за променливи свързани с базата.
*/
/* Показване на всички грешки */
ini_set('error_reporting', E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
ini_set('html_errors', TRUE);

$db_host = '127.0.0.1'; 	// или localohst
$db_name   = 'netitcms'; 	// Име на базата данни
$db_user = 'root';			// MySQL потребител
$db_pass = '';			// MySQL парола
$charset = 'utf8';

$dsn = "mysql:host={$db_host};dbname={$db_name};charset=$charset";

$pdo = new PDO($dsn, $db_user, $db_pass);

$apiKey = "9fe91d3688b20efc8a76c2b81db9b526ae3e1686a75e699f32fdb4041ab19593";

$defaultCategorie = "Other";

$categories = [
	'Stuff', 'Music', 'Fiction'
]; // Или си дефинирайте свои собствени, но не ги променяйте в бъдеще.

$contentTypes = ["Page", "News", "Course"];
```