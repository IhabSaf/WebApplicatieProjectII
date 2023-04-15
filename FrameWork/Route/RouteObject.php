<?php
namespace FrameWork\Route;
use FrameWork\Database\EntityManger;
use FrameWork\Interface\RequestInterface;

class RouteObject
{
    public function __construct(
        private string $name,
        private string $controllerClass,
        private string $controllerMethod,
        private string $fullUrl,
        private string $baseUrl,
        private ?array $urlParams = null){}

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

    public function getUrlParams(): ?array
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

    public function setUrlParamsWithoutDefault($route): void
    {
        $params = $this->getParams($this->fullUrl);
        $values = $this->getParams($route);
        for ($i = 0; $i < count($params); $i++) {
            $this->urlParams[$params[$i]] = $values[$i];
        }
    }

    public function hasParams(): bool
    {
        return str_contains($this->fullUrl, '{');
    }

    public function controller(RequestInterface $request, EntityManger $entityManger = null): array
    {
        if(isset($entityManger)){
            return [new $this->controllerClass($request, $entityManger), $this->controllerMethod]($request);
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

    private function getParams($route){
        $params = substr($route, strlen($this->baseUrl) + 1);
        // path is fullpath
        if(str_contains($params,'{')){
            $params = str_replace(['{', "}"], [" ", ""], $params);
        }
        // path has multiple url params
        elseif(str_contains($params, '/')){
            $params = str_replace("/", " ", $params);
        }
        // path has one url param
        else{
            return [$params];
        }
        $params = explode(" ", $params);
        array_shift($params);
        return $params;
    }
}
