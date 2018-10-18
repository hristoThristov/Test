<?php
/**
 * @file
 *  Logs the user out.
 */
session_start();

include "./functions/common.php";

 if(isLoggedIn()) {
    unset($_SESSION['user']);
    session_destroy();
 }
 
 header("Location: index.php");