<?php
namespace FrameWork\Route;
class Route {
    private $routes;

    private $controller;

    private $method;
    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute(string $name, string $controller, string $route, array $paramDefaults = []): void
    {
        $routeOject = $this->createRouteObject($name, $controller, $route, $paramDefaults);
        $this->routes[] = $routeOject;
    }

    public function isValidRoute(string $route): bool
    {
        foreach ($this->routes as $routeObject){
            if(str_contains($route, $routeObject->getBaseUrl())){
                return true;
            }
        }
        return false;
    }

    public function getRoute(string $route): ?RouteObject
    {
        foreach ($this->routes as $routeObject){

            // route has no params
            if($route == $routeObject->getBaseUrl()){
                return $routeObject;
            }

            if(str_contains($route, $routeObject->getBaseUrl())){
                $paramUrl = str_replace($routeObject->getBaseUrl() . "/", "", $route);
                $params = explode("/", $paramUrl);
                $routeObject->setParams($params);
                return $routeObject;
            }
        }
        return null;
    }

    public function allRoutes(): array
    {
        return $this->routes;
    }
    private function createRouteObject(string $name, string $controller, string $route, array $paramDefaults): RouteObject
    {
        $controllerParts = explode(":", $controller);
        $controllerClass = $controllerParts[0];
        $this->controller = $controllerParts[0];
        $controllerMethod = $controllerParts[1];
        $this->method = $controllerParts[1];

        $array = explode('{', $route);
        $baseUrl = $array[0];
        array_shift($array);
        $array = str_replace(["}", "/"], "", $array);
        if(str_ends_with($baseUrl, '/')){
            $baseUrl = substr($baseUrl, 0, -1);
        }
        $paramDefaultOrdered = [];
        foreach ($array as $paramName){
            $paramDefaultOrdered[$paramName] = $paramDefaults[$paramName];
        }
        return new RouteObject($name, $controllerClass, $controllerMethod, $route, $baseUrl, $paramDefaultOrdered);
    }



}