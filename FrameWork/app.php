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
    public function __construct(
        #[Service(Request::class), Argument(post: [], get: [], server: [], cookie: [])] private IRequest $request,
        private EventDispatcher $eventDispatcher,
        private Route $route,
        #[Service(Response::class), Argument(body: '', statusCode: 200)] private IResponse $response){}

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
        $this->route->addRoute("temp", 'src\Controller\MainController:handle', "/temp/{name}/{id}", ["name" => "person", "id" => 5]);
        $this->route->addRoute("test", 'src\Controller\MainController:handle', "/test");
    }
    public function idk() {
        var_dump("idk");
        die();
    }

    private function create_default_event_dispatcher(EventDispatcher $eventDispatcher): void
    {
        $controller = str_replace('_controller:', "", );
        $this->eventDispatcher->addListener(KernelEvent::KERNEL_REQUEST, 'src\Controller\\'.$controller);
//        $this->eventDispatcher->addListener(KernelEvent::KERNEL_CONTROLLER, 'src\Controller\MainController');
//        $this->eventDispatcher->addListener(KernelEvent::KERNEL_VIEW, 'src\Controller\MainController');
//        $this->eventDispatcher->addListener(KernelEvent::KERNEL_RESPONSE, 'src\Controller\MainController');
//        $this->eventDispatcher->addListener(KernelEvent::KERNEL_TERMINATE, 'src\Controller\MainController');
    }
}