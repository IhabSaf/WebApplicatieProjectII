<?php
namespace FrameWork;

use FrameWork\Class\Response;
use FrameWork\Interface\IRequest;
use FrameWork\Interface\IResponse;
use FrameWork\Route\Route;
class App {
    public function __construct()
    {
    }

    public function handle(IRequest $request): IResponse {
        $route = new Route();
        $route->addRoute("temp", "/temp/{name}/{id}", ["name" => "person", "id" => 5]);
        $route->addRoute("test", "/test");
        $response = new Response();
        $path = $request->getPathInfo();
        if($route->isValidRoute($path)) {
            $routeObject = $route->getRoute($path);
            ob_start();
            extract($routeObject->getParams(), EXTR_SKIP);
            include sprintf('./FrameWork/View/%s.php', $routeObject->getBaseUrl());
            $response->setContent(ob_get_clean());
        } else {
            $response->setStatusCode(404);
            $response->setContent("Deze pagina bestaat niet.");
        }
        return $response;
    }
}