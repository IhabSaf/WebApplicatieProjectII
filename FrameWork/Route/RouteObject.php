<?php
namespace FrameWork\Route;
class RouteObject
{
    private string $fullUrl;
    private string $baseUrl;
    private array $params;

    public function __construct(string $fullUrl, string $baseUrl, array $params = [])
    {
        $this->fullUrl = $fullUrl;
        $this->baseUrl = $baseUrl;
        $this->params = $params;
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
}