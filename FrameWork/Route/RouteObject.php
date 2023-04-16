<?php

namespace FrameWork\Route;

/**
 * @webTech2:
 *
 *  @INHOUD:
 *          Klaase: De RouteObject klasse is een onderdeel van een framework voor het beheren van routes binnen een webapplicatie
 *                  Het heeft als doel om de informatie over een specifieke route te bevatten, zoals de naam van de route, de URL, de controller class en method.
 *                  en de eventuele URL parameters.
 *
 */

class RouteObject implements RouteObjectInterface
{
    public function __construct(
        private string $name,
        private string $controllerClass,
        private string $controllerMethod,
        private string $fullUrl,
        private string $baseUrl,
        private ?array $urlParams = null){}

    /**
     * @return string
     */

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFullUrl(): string
    {
        return $this->fullUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return array|null
     */

    public function getUrlParams(): ?array
    {
        return $this->urlParams;
    }

    /**
     * @param $urlParams
     * @return void
     */

    public function setUrlParams($urlParams): void
    {
        $count = 0;
        foreach ($this->urlParams as $paramName => $paramValue){
            $this->urlParams[$paramName] = $urlParams[$count] ?? $this->urlParams[$paramName];
            $count++;
        }
    }

    /**
     * @param $route
     * @return void
     */

    public function setUrlParamsWithoutDefault($route): void
    {
        $params = $this->getParams($this->fullUrl);
        $values = $this->getParams($route);
        for ($i = 0; $i < count($params); $i++) {
            $this->urlParams[$params[$i]] = $values[$i];
        }
    }

    /**
     * @return bool
     */
    public function hasParams(): bool
    {
        return str_contains($this->fullUrl, '{');
    }

    /**
     * @return string
     */
    public function getReturnType(): string
    {
        return $this->returnType;
    }

    /**
     * @return string
     */

    public function getController()
    {
        return $this->controllerClass;
    }

    /**
     * @return string
     */

    public function getMethod()
    {
        return $this->controllerMethod;
    }

    /**
     * @param $route
     * @return array|string[]
     */
    private function getParams($route){
        $params = substr($route, strlen($this->baseUrl) + 1);
        // path is fullpath
        if (str_contains($params,'{')) {
            $params = str_replace(['{', "}"], [" ", ""], $params);
        } elseif (str_contains($params, '/')) { // path has multiple url params
            $params = str_replace("/", " ", $params);
        } else { // path has one url param
            return [$params];
        }
        $params = explode(" ", $params);
        array_shift($params);
        return $params;
    }
}
