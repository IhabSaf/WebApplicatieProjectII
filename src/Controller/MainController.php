<?php

namespace src\Controller;
use FrameWork\Interface\IRequest;
use FrameWork\Route\RouteObject;

class MainController
{
    public function __construct(){}

    public function index() {
        $test = "hoi";
        return ['test' => $test];
    }
}