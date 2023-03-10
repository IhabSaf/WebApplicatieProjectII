<?php

class Request
{
    private $post;
    private $get;
    private $server;
    private $cookie;

    public function __construct()
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->server = $_SERVER;
        $this->cookie = $_COOKIE;
    }

    public function getServer():array{
        return $this->server;
    }

    public function getCookieByName(String $name):string {
        return $this->cookie[$name];
    }

    public function getGetParam(string $name):string {
        return $this->get[$name];
    }

    public function getPost(String $name): string{
        return $this->post[$name];
    }

}

