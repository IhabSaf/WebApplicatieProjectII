<?php

require_once "./vendor/autoload.php";

use FrameWork\database\Query;

$connect = new \FrameWork\database\DatabaseConnection();
$user = new \FrameWork\src\Model\User();
$result = Query::select()->from($user->)->execute($connect);

var_dump($result);


//$email = $_POST['email'];
//$password = $_POST['password'];
//
//$inlog = Query::select('ihab')->from('user')->execute($connect);
//setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
//
//<!--<!DOCTYPE html>-->
//<!--<html>-->
//<!--<body>-->
//<!---->

//if(!isset($_COOKIE[$cookie_name])) {
//    echo "Cookie named '" . $cookie_name . "' is not set!";
//} else {
//    echo "Cookie '" . $cookie_name . "' is set!<br>";
//    echo "Value is: " . $_COOKIE[$cookie_name];
//}
//?>
<!---->
<!--</body>-->
<!--</html>-->