<?php
namespace FrameWork;
use Exception;
use FrameWork\Event\EventDispatcher;
use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Interface\IRequest;
use FrameWork\Interface\IResponse;
use FrameWork\Route\Route;
use FrameWork\Route\RouteObject;


class App
{
    public function __construct(
        #[Service(Request::class), Argument(post: [], get: [], server: [], cookie: [])] private IRequest $request,
        private EventDispatcher                                                                          $eventDispatcher,
        public Route                                                                                     $route,
        #[Service(Response::class), Argument(body: '', statusCode: 200)] private IResponse               $response)
    {
    }

    public function handle(): IResponse
    {
        $this->create_routes();
        //$eventDispatcher = $this->create_default_event_dispatcher($this->eventDispatcher);
        //$eventDispatcher->dispatch($this->request, KernelEvent::KERNEL_REQUEST);
        $path = $this->request->getPathInfo();
        if ($this->route->isValidRoute($path)) {
            $routeObject = $this->route->getRoute($path);
            ob_start();
            extract($routeObject->getParams(), EXTR_SKIP);
            $routeObject->controller($this->request);
            include sprintf(__DIR__ . '/../templates/%s.html', $routeObject->getBaseUrl());
            $this->response->setContent(ob_get_clean());
        } else {
            $this->response->setStatusCode(404);
            $this->response->setContent("Deze pagina bestaat niet.");
        }
        return $this->response;
    }

    private function create_routes(): void
    {
//        $this->route->addRoute("temp", 'src\Controller\MainController:handle', "/temp/{name}/{id}", ["name" => "person", "id" => 5]);
//        $this->route->addRoute("test", 'src\Controller\MainController:handle', "/test");
        $this->route->addRoute("test", 'src\Controller\MyController:index', "/test");
        $this->route->addRoute("test", 'src\Controller\RegistrationController:registration', "/Registration");

    }


    private function render(RouteObject $routeObject, array $controllerResult): string
    {
        if ($routeObject->getReturnType() === 'html') {
            ob_start();
            extract($routeObject->getParams(), EXTR_SKIP);
            include sprintf(__DIR__ . '/../templates/%s.html', $routeObject->getBaseUrl());
            $html = ob_get_clean();
            return $html;
        } else if ($routeObject->getReturnType() === 'controller') {
            $controllerTarget = $controllerResult['controller'];
            $method = $controllerResult['method'];
            $controller = new $controllerTarget();
            $response = $controller->$method($this->request);
            return $response->getContent();
        } else {
            throw new Exception('Invalid return type');
        }
    }

}