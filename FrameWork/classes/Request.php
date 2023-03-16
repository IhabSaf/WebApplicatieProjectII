<?php

class Request
{
    private $post;
    private $get;
    private $server;
    private $cookie;

    public function __construct(array $post, array $get, array $server, array $cookie)
    {
        $this->post = $post;
        $this->get = $get;
        $this->server = $server;
        $this->cookie = $cookie;
    }

    public static function makeWithGlobals(): Request
    {
        return new Request($_POST, $_GET, $_SERVER, $_COOKIE);
    }

    public function getServer():array
    {
        return $this->server;
    }

    public function getGet(): array {
        return $this->get;
    }

    public function getCookieByName(String $name):string
    {
        return $this->cookie[$name];
    }

    public function getGetParam(string $name):string
    {
        return $this->get[$name];
    }

    public function getPost(String $name): string
    {
        return $this->post[$name];
    }
}

