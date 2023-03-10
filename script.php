<pre>
<?php

//function Autoloader($className)
//{
//    // Map namespace prefix to base directory
//    $prefix = 'MyVendor\\';
//    $baseDir = __DIR__ . '/src/';
//
//    // Does the class use the namespace prefix?
//    $len = strlen($prefix);
//    if (strncmp($prefix, $className, $len) !== 0) {
//        // No, move to the next registered autoloader
//        return;
//    }
//
//    // Get the relative class name
//    $relativeClass = substr($className, $len);
//
//    // Replace namespace separators with directory separators
//    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
//
//    // If the file exists, require it
//    if (file_exists($file)) {
//        require $file;
//    }
//}
//
//
//
//spl_autoload_register('Autoloader');

#My eigen versie:
spl_autoload_register(function ($class){
    require 'FrameWork/classes/' . $class . '.php';
});
//
//$var = new Testing1();
//print_r($var);

$var = new Request();
//$var ->getGet();

var_dump($_COOKIE);
var_dump($var->getCookieByName('Phpstorm-64584131'));

var_dump($var->getGetParam('foo'));

$response = new Response("Dit is een test voor mijn Response Klaase");
