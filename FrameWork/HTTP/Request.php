<?php

namespace FrameWork\HTTP;

use FrameWork\Interface\RequestInterface;

class Request implements RequestInterface
{
    public function __construct(
        private array $post ,
        private array $get,
        private array $server,
        private array $cookie,
        private array $session,
        private array $attributes = [],
    ){}

    public static function makeWithGlobals(array $attributes = []): RequestInterface
    {
        @session_start();
        return new Request($_POST, $_GET, $_SERVER, $_COOKIE, $_SESSION, $attributes);
    }

    public function saveSession()
    {
        $_SESSION = $this->session;
    }

    public function getSession()
    {
        return $this->session;
    }

    public function getSessionValueByName(string $name): ?string
    {
        return $this->session[$name] ?? null;
    }

    public function setSessionValueByName(string $name, string $value): void
    {
        $this->session[$name] = $value;
    }

    public function endSession(): void
    {
        session_unset();
        session_destroy();
        $this->session = [];
    }

    public function setAttribute(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public function setMutipleAttributes(array $attributes): void
    {
        $this->attributes += $attributes;
    }

    public function getAttributeByName(string $name): ?string
    {
        return $this->attributes[$name];
    }

    public function getServer(): array
    {
        return $this->server;
    }

    public function getServerByName(string $name): ?string
    {
        return $this->server[$name];
    }

    public function getGet(): array
    {
        return $this->get;
    }

    public function getGetByName(string $name): ?string
    {
        return $this->get[$name];
    }

    public function getGetSecure(): array
    {
        $secure = [];
        foreach ($this->get as $key => $value){
            $secure[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }

        return $secure;
    }

    public function hasGet(string $name){
        return isset($this->get[$name]);
    }

    public function getCookieByName(String $name): ?string
    {
        return $this->cookie[$name];
    }

    public function getPostByName(String $name): ?string
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

    public function isPost(): bool
    {
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