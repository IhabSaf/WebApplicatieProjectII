<?php

namespace FrameWork\Route;

/**
 * @webTech2:
 *
 *  @INHOUD:
 *          Klaase: De Route-klasse wordt gebruikt om routes te beheren voor een webapplicatie.
 *                  Het maakt het mogelijk om routes toe te voegen, op te halen en de geldigheid van routes te controleren.
 *                  De klasse is gedefinieerd onder de FrameWork\Route-namespace.
 *
 */
class Route implements RouteInterface {
    public function __construct(private array $routes = [],
                                private string $routeObjectClass = "RouteObject")
    {
        $this->createDefaultRoutes();
    }


    /**
     * @param string $name
     * @param string $controller
     * @param string $route
     * @param array|null $paramDefaults
     * @return void
     */
    // voeg een routeObject toe
    public function addRoute(string $name, string $controller, string $route, array $paramDefaults = null): void
    {
        $routeOject = $this->createRouteObject($name, $controller, $route, $paramDefaults);
        $this->routes[$name] = $routeOject;
    }


    /**
     * @param string $route
     * @return bool
     */
    // check of de route bestaat
    public function isValidRoute(string $route): bool
    {
        foreach ($this->routes as $routeObject){
            if (str_contains($route, $routeObject->getBaseUrl())) {
                return true;
            }
        }
        return false;
    }


    /**
     * @param string $route
     * @return object|null
     */
    // haal één routeObject op
    public function getRoute(string $route): ?RouteInterface
    {
        foreach ($this->routes as $routeObject){
            // route has no params
            if ($route == $routeObject->getBaseUrl()) {
                return $routeObject;
            }

            if (str_contains($route, $routeObject->getBaseUrl())) {
                $paramUrl = str_replace($routeObject->getBaseUrl() . "/", "", $route);
                $params = explode("/", $paramUrl);
                $routeObject->setUrlParams($params);
                return $routeObject;
            }
        }
        return null;
    }


    /**
     * @return array
     */
    // geeft alle routes terug
    public function allRoutes(): array
    {
        return $this->routes;
    }

    /**
     * @param string $name
     * @param string $controller
     * @param string $route
     * @param array|null $paramDefaults
     * @return RouteObjectInterface
     */

    // maakt een RouteOject aan
    private function createRouteObject(string $name, string $controller, string $route, ?array $paramDefaults): RouteObjectInterface
    {

        $controllerParts = explode(":", $controller);
        $controllerClass = $controllerParts[0];
        $controllerMethod = $controllerParts[1];

        $array = explode('{', $route);
        $baseUrl = $array[0];
        array_shift($array);
        $array = str_replace(["}", "/"], "", $array);
        if (str_ends_with($baseUrl, '/') && strcmp($baseUrl,'/') !== 0) {
            $baseUrl = substr($baseUrl, 0, -1);
        }
        $paramDefaultOrdered = [];
        if (isset($paramDefaults)) {
            foreach ($array as $paramName){
                $paramDefaultOrdered[$paramName] = $paramDefaults[$paramName];
            }
        }
        return new $this->routeObjectClass($name, $controllerClass, $controllerMethod, $route, $baseUrl, $paramDefaultOrdered);
    }


    /**
     * @return void
     */

    // default routes die deze applicatie heeft
    // bij het ophalen van de template wordt naar de name gekeken
    // bij name "home" hoort home.html in de templates map
    private function createDefaultRoutes(): void
    {
        $this->addRoute("home", 'src\Controller\MainController:index', "/home");
        $this->addRoute("registration", 'src\Controller\RegistrationController:registration', "/registration");
        $this->addRoute("login", 'src\Controller\LoginController:loginUser', "/login");
        $this->addRoute("logout", 'src\Controller\LoginController:logout', "/logout");
        $this->addRoute("registerExam", 'src\Controller\InschrijvenTentamenController:inschrijven', "/registerExam");
        $this->addRoute("addGradeInfo", 'src\Controller\GiveCijferController:addGradeInfo', "/addGradeInfo");

        $this->addRoute("findTentamenForm", 'src\Controller\GiveCijferController:findTentamenForm', "/findTentamenForm");
        $this->addRoute("addStudentGrade", 'src\Controller\GiveCijferController:addStudentGrade', "/addStudentGrade/{id}");
        $this->addRoute("showStudentData", 'src\Controller\ShowResultaatController:show', "/showStudentData");
    }
}