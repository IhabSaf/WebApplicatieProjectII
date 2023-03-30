<pre>
<?php
require_once "./vendor/autoload.php";

//use FrameWork\Class\Header;
use FrameWork\App;


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$request = \FrameWork\Class\Request::makeWithGlobals();
$app = new App();
$response = $app->handle($request);
$response->send();