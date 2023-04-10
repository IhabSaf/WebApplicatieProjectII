<?php
namespace FrameWork\Route;
use FrameWork\Interface\IRequest;

class RouteObject
{
    public function __construct(
        private string $name,
        private string $controllerClass,
        private string $controllerMethod,
        private string $fullUrl,
        private string $baseUrl,
        private string $returnType = 'html',
        private array $params = []){}

    public function getName(): string
    {
        return $this->name;
    }
    public function getFullUrl(): string
    {
        return $this->fullUrl;
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams($params): void
    {
        $count = 0;
        foreach ($this->params as $paramName => $paramValue){
            $this->params[$paramName] = $params[$count] ?? $this->params[$paramName];
            $count++;
        }
    }

    public function hasParams($route): bool
    {
        $paramUrl = str_replace('/'.$this->getBaseUrl().'/', "", $route);
        return false;
    }

    public function controller(IRequest $request): array
    {
        return [new $this->controllerClass($request, $this), $this->controllerMethod]();
    }

    public function getReturnType(): string
    {
        return $this->returnType;
    }
}