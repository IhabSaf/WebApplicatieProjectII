<?php

require_once "./vendor/autoload.php";

use FrameWork\database\Query;

$connect = new \FrameWork\database\DatabaseConnection();
$result = Query::select('email')->from('user')->execute($connect);

var_dump($result);{

}