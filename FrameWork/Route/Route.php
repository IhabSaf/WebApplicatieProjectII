<?php
namespace FrameWork\Route;
class Route {
    private $routes;
    public function __construct()
    {
        $this->routes = [];
    }

    public function addRoute(string $name, string $route, array $paramDefaults = []): void
    {
        $routeOject = $this->createRouteObject($route, $paramDefaults);
        $this->routes[] = $routeOject;
    }

    public function isValidRoute(string $route)
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
    private function createRouteObject(string $route, array $paramDefaults): RouteObject
    {
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
        return new RouteObject($route, $baseUrl, $paramDefaultOrdered);
    }
}