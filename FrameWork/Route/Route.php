<?php
namespace FrameWork\Route;
class Route {
    private $routes;
    private $controller;
    private $method;
    public function __construct()
    {
        $this->routes = [];
        $this->createDefaultRoutes();
    }

    public function addRoute(string $name, string $controller, string $route, array $paramDefaults = []): void
    {
        $routeOject = $this->createRouteObject($name, $controller, $route, $paramDefaults);
        $this->routes[$name] = $routeOject;
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

    private function createDefaultRoutes(): void
    {
        $this->addRoute("test", 'src\Controller\MainController:index', "/home");
        $this->addRoute("registration", 'src\Controller\RegistrationController:registration', "/registration");
        $this->addRoute("loginUser", 'src\Controller\LoginController:loginUser', "/login");
        $this->addRoute("logout", 'src\Controller\LoginController:logout', "/logout");
        $this->addRoute("registerExam", 'src\Controller\InschrijvenTentamenController:inschrijven', "/registerExam");
        $this->addRoute("CijferToevoegen", 'src\Controller\GiveCijfer:niks', "/CijferToevoegen");
        $this->addRoute("FindStudentForm", 'src\Controller\GiveCijfer:findStudentForm', "/FindStudentForm");
        $this->addRoute("FindeStudentSubject", 'src\Controller\GiveCijfer:invulCijfer', "/FindeStudentSubject");
        $this->addRoute("Finde2StudentSubject", 'src\Controller\ShowResultaatController:show', "/ShowStudentData");
    }
}