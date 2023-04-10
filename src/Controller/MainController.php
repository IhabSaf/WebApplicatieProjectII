<?php

namespace src\Controller;
use FrameWork\Interface\IRequest;
use FrameWork\Route\RouteObject;

class MainController
{
    public function __construct(private IRequest $request, private RouteObject $routeObject){}

    public function handle() {
        echo "i;m in a controller";
        return [];
    }
}