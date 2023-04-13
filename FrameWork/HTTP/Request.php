<?php
namespace FrameWork\HTTP;
use FrameWork\Interface\IRequest;

class Request implements IRequest
{
    public array $atributes = [];
    public function __construct(
        private array $post ,
        private array $get,
        private array $server,
        private array $cookie){}

    public static function makeWithGlobals(): IRequest
    {
        return new Request($_POST, $_GET, $_SERVER, $_COOKIE);
    }

    public function getServer():array
    {
        return $this->server;
    }

    public function getServerByName(string $name): string
    {
        return $this->server[$name];
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

    public function getPostByName(String $name): string
    {
        return $this->post[$name];
    }

    public function getPost(): array
    {
        return $this->post;
    }
    public function getPostSecure(): array
    {
        $secure = [];
        foreach ($this->post as $key => $value){
            $secure[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $secure;
    }


    public function getPathInfo(): string
    {
        return str_replace('//', '/', '/'.explode('?', $this->server['REQUEST_URI'] ?? '')[0]);
    }

    public function isPost(): bool{
        return $this->server['REQUEST_METHOD'] === 'POST';
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