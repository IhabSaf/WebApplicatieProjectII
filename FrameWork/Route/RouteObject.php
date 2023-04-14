<?php
namespace FrameWork\Route;
use FrameWork\Interface\RequestInterface;

class RouteObject
{
    public function __construct(
        private string $name,
        private string $controllerClass,
        private string $controllerMethod,
        private string $fullUrl,
        private string $baseUrl,
        private array $urlParams = []){}

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

    public function getUrlParams(): array
    {
        return $this->urlParams;
    }

    public function setUrlParams($urlParams): void
    {
        $count = 0;
        foreach ($this->urlParams as $paramName => $paramValue){
            $this->urlParams[$paramName] = $urlParams[$count] ?? $this->urlParams[$paramName];
            $count++;
        }
    }

    public function hasParams($route): bool
    {
        $paramUrl = str_replace('/'.$this->getBaseUrl().'/', "", $route);
        return false;
    }

    public function controller(RequestInterface $request, object $object = null): array
    {
        if(isset($test)){
            return [new $this->controllerClass($request, $object), $this->controllerMethod]($request);
        }
        return [new $this->controllerClass($request), $this->controllerMethod]($request);
    }

    public function getReturnType(): string
    {
        return $this->returnType;
    }

    public function getController()
    {
        return $this->controllerClass;
    }

    public function getMethod()
    {
        return $this->controllerMethod;
    }
}
