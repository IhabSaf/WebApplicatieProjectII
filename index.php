<pre>
<?php
require_once "./vendor/autoload.php";

//use FrameWork\HTTP\Header;
use FrameWork\App;
use FrameWork\DiContainer;
use FrameWork\Event\ControllerResolver;
use FrameWork\Event\EventDispatcher;
use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Route\Route;


ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$diContrainer = new DiContainer();
$app = $diContrainer->createApp();
$response = $app->handle();
$response->send();