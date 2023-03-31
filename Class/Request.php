<?php
namespace FrameWork\Class;
use FrameWork\Interface\IRequest;

class Request implements IRequest
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

    public static function makeWithGlobals(): IRequest
    {
        return new Request($_POST, $_GET, $_SERVER, $_COOKIE);
    }

    public function getServer():array
    {
        return $this->server;
    }

    public function getGet(): array
    {
        return $this->get;
    }

    public function getGetSecure(): array
    {
        $secure = [];
        foreach ($this->get as $key => $value){
            $secure[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        return $secure;
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

    public function getPathInfo(): string
    {
        return str_replace('//', '/', '/'.explode('?', $this->server['REQUEST_URI'] ?? '')[0]);
    }

    public function dump(): void
    {
        echo "POST \n";
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
        var_dump($this->post);
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
        echo "GET \n";
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
        var_dump($this->get);
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
        echo "SERVER \n";
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
        var_dump($this->server);
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
        echo "COOKIE \n";
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
        var_dump($this->cookie);
        echo "|||||||||||||||||||||||||||||||||||||||||||||||||||||||||| \n";
    }
}