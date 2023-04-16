<?php

namespace FrameWork;

use FrameWork\HTTP\Response;
use FrameWork\Interface\RequestInterface;
use FrameWork\Interface\ResponseInterface;
use FrameWork\Route\RouteObjectInterface;

class Template
{
    public function __construct(#[Service(Response::class), Argument(body: '', statusCode: 200)] private ResponseInterface $response){}

    public function renderPage(RequestInterface $request, RouteObjectInterface $routeObject, array $array): ResponseInterface
    {
        ob_start();
        $urlParams = $routeObject->getUrlParams();
        if (isset($urlParams)) {
            extract($urlParams, EXTR_SKIP);
        }
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