<?php
namespace FrameWork;

use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Interface\IRequest;
use FrameWork\Interface\IResponse;
use FrameWork\Route\Route;
use FrameWork\security\AccessController;
use ReflectionClass;

class App
{
    public function __construct(
        #[Service(Request::class), Argument(post: [], get: [], server: [], cookie: [])] private IRequest $request,
        private Route $route){}

    public function handle(): IResponse
    {
        $response = new Response();
        $array = [];
        $this->create_routes();
        $path = $this->request->getPathInfo();
        if ($this->request->getServer()['REQUEST_METHOD'] === 'POST') {
            $array += $this->request->getPostSecure();
        }
        if ($this->route->isValidRoute($path)) {
            $routeObject = $this->route->getRoute($path);

            // Check  de accessController
            $checkController = $this->route->getController(); // dit pakt laatste controller van de arrey routeobject
            $checkMethod = $this->route->getMethod();
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] !== null) {
                $userRole = $_SESSION['user_role'];
            } else {
                $userRole = 'gast';
            }
            var_dump($checkController);

            $hasAccess = AccessController::checkAccess($userRole, $checkController, $checkMethod);
            var_dump($hasAccess);
            if (!$hasAccess) {
                $response->setStatusCode(403);
                $response->setContent("Access denied.");
                return $response;
            }

            ob_start();
            extract($routeObject->getParams(), EXTR_SKIP);
            $array += $routeObject->controller($this->request);
            extract($array, EXTR_SKIP);
            include sprintf(__DIR__ . '/../templates/%s.html', $routeObject->getBaseUrl());
            $response->setContent(ob_get_clean());

        } else {
            $response->setStatusCode(404);
            $response->setContent("Deze pagina bestaat niet.");
        }
        return $response;
    }

    private function create_routes(): void
    {
        $this->route->addRoute("temp", 'src\Controller\MainController:handle', "/temp/{name}/{id}", ["name" => "person", "id" => 5]);
        $this->route->addRoute("test", 'src\Controller\MainController:index', "/home");
        $this->route->addRoute("registration", 'src\Controller\RegistrationController:registration', "/Registration");
//        $this->route->addRoute("loginUser", 'src\Controller\LoginController:loginUser', "/login");


    }
}