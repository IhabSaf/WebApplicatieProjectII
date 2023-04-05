<?php

namespace src\Controller;
use FrameWork\HTTP\Request;

class MainController
{
    public function __construct()
    {
    }

    public function handle(Request $request) {
        var_dump("Dit is de main controller!");
    }
}