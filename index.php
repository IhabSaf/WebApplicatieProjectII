<pre>
<?php
require_once "./vendor/autoload.php";

use FrameWork\Database\DatabaseConnection;
use FrameWork\DiContainer;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
//$db = new DatabaseConnection();
//$query = new \FrameWork\database\Query();
$diContrainer = new DiContainer();
$app = $diContrainer->createApp();
$response = $app->handle();
$response->send();
?>