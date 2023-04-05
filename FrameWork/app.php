<?php
namespace FrameWork;

use FrameWork\Event\ControllerResolver;
use FrameWork\Event\EventDispatcher;
use FrameWork\Event\KernelEvent;
use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Interface\IRequest;
use FrameWork\Interface\IResponse;
use FrameWork\Route\Route;
use src\Controller\MainController;

class App
{
    public function __construct()
    {
    }

    public function handle(#[Service(Request::class)] IRequest $request, EventDispatcher $eventDispatcher, ControllerResolver $controllerResolver, Route $route, #[Service(Response::class)] IResponse $response): IResponse
    {
        $route = $this->create_routes($route);
        $response = $controllerResolver->getController($request, $response);
        $eventDispatcher = $this->create_default_event_dispatcher($eventDispatcher, $response);
        $eventDispatcher->dispatch($request, KernelEvent::KERNEL_REQUEST);
        $path = $request->getPathInfo();
        if ($route->isValidRoute($path)) {
            $routeObject = $route->getRoute($path);
            ob_start();
            extract($routeObject->getParams(), EXTR_SKIP);
            include sprintf(__DIR__ . '/../templates/%s.html', $routeObject->getBaseUrl());
            $response->setContent(ob_get_clean());
        } else {
            $response->setStatusCode(404);
            $response->setContent("Deze pagina bestaat niet.");
        }
        return $response;
    }

    private function create_routes(Route $route): Route
    {
        $route->addRoute("temp", "/temp/{name}/{id}", ["name" => "person", "id" => 5]);
        $route->addRoute("test", "/test");
        return $route;
    }
    public function idk() {
        var_dump("idk");
        die();
    }

    private function create_default_event_dispatcher(EventDispatcher $eventDispatcher, IResponse $response): EventDispatcher
    {
        $controller = str_replace('_controller:', "", $response->getHeader('_controller'));
        $eventDispatcher->addListener(KernelEvent::KERNEL_REQUEST, 'src\Controller\\'.$controller);
//        $eventDispatcher->addListener(KernelEvent::KERNEL_CONTROLLER, 'src\Controller\MainController');
//        $eventDispatcher->addListener(KernelEvent::KERNEL_VIEW, 'src\Controller\MainController');
//        $eventDispatcher->addListener(KernelEvent::KERNEL_RESPONSE, 'src\Controller\MainController');
//        $eventDispatcher->addListener(KernelEvent::KERNEL_TERMINATE, 'src\Controller\MainController');
        return $eventDispatcher;
    }
}