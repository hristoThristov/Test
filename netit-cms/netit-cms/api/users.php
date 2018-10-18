<?php
/**
 * @file
 *  API file for retrieveing and saving user information.
 * 
 *  The API implements app-to-app authentication with GET parameter <i>key</i>.
 *  The key has to be equal to <strong>9fe91d3688b20efc8a76c2b81db9b526ae3e1686a75e699f32fdb4041ab19593</strong>,
 *  otherwise the request won't be executed.
 */
header('Content-Type: application/json');

include "../config/config.php";
include "../functions/common.php";

if(empty($_GET['key']) || $_GET['key'] != "9fe91d3688b20efc8a76c2b81db9b526ae3e1686a75e699f32fdb4041ab19593") {
    echo json_encode("Authentication required!");
    die();
}

include "../src/User.class.php";
include "../src/API.class.php";
include "../src/UserAPI.class.php";

if($_SERVER['REQUEST_METHOD'] == "POST") { // POST - създаваме нов потребител.
    $api = new UserAPI($pdo, $_SERVER['REQUEST_METHOD'], $_POST);
    echo $api->insert()->getJSON();
}
else if($_SERVER['REQUEST_METHOD'] == "GET") { // GET - или даваме всички потребители, или само един ако е подаден id ключ.
    $api = new UserAPI($pdo, $_SERVER['REQUEST_METHOD']);
    echo $api->getItems(@$_GET['id'])->getJSON();
}

die();