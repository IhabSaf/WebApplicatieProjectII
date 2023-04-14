<?php
namespace FrameWork;

use FrameWork\HTTP\Request;
use FrameWork\HTTP\Response;
use FrameWork\Interface\RequestInterface;
use FrameWork\Interface\ResponseInterface;
use FrameWork\Route\Route;
use FrameWork\Route\RouteObject;
use FrameWork\security\AccessController;

class Template
{
    public function __construct(#[Service(Response::class), Argument(body: '', statusCode: 200)] private ResponseInterface $response){}

    public function renderPage(RouteObject $routeObject, array $array): ResponseInterface
    {
        ob_start();
        extract($routeObject->getUrlParams(), EXTR_SKIP);
        extract($array, EXTR_SKIP);
        include sprintf(__DIR__ . '/../templates/%s.html', $routeObject->getName());
        $this->response->setContent(ob_get_clean());
        return $this->response;
    }

    public function renderSimple(string $message, int $statusCode): Response
    {
        $this->response->setStatusCode($statusCode);
        $this->response->setContent($message);
        return $this->response;
    }
}