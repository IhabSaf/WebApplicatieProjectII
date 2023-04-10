<?php
namespace FrameWork;

use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Interface\IRequest;
use FrameWork\Interface\IResponse;
use FrameWork\Route\Route;

class App
{
    public function __construct(
        #[Service(Request::class), Argument(post: [], get: [], server: [], cookie: [])] private IRequest $request,
        private Route $route,
        #[Service(Response::class), Argument(body: '', statusCode: 200)] private IResponse $response){}

    public function handle(): IResponse
    {
        $this->create_routes();
        $path = $this->request->getPathInfo();
        if ($this->route->isValidRoute($path)) {
            $routeObject = $this->route->getRoute($path);
            ob_start();
            extract($routeObject->getParams(), EXTR_SKIP);
            $array = $routeObject->controller($this->request);
            extract($array, EXTR_SKIP);
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
}