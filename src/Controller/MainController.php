<?php

namespace src\Controller;
use FrameWork\Interface\RequestInterface;
use FrameWork\Route\Redirect;
use FrameWork\Route\Route;
use FrameWork\Route\RouteObject;

class MainController
{
    public function __construct(){}

    public function index(RequestInterface $request) {
        //$redirect = new Redirect();
        //$redirect->toUrl('registration');
        return [];

    }
}