<?php

namespace FrameWork\HTTP;

use FrameWork\Interface\HeaderInterface;
use FrameWork\Interface\ResponseInterface;

class Response implements ResponseInterface
{
    public function __construct(private string $body = '',
                                #[Service(Header::class)] private HeaderInterface $headers = new Header(),
                                private int $statusCode = 200){}

    public function addHeader(string $name, string $value): void
    {
        $this->headers->addHeader($name.":".$value, false);
    }

    public function setHeader(string $name, string $value): void
    {
        $this->headers->addHeader($name.":".$value);
    }

    public function getHeader(string $key): ?string
    {
        return $this->headers->getHeader($key) ?? null;
    }
    public function setStatusCode(int $statusCode): void
    {
            $this->statusCode = $statusCode;
    }
    public function allHeaders(): HeaderInterface
    {
        return $this->headers;
    }
    public function setContent(string $body): void
    {
        $this->body = $body;
    }

    public function send(): void
    {
        echo $this->body;
    }

    public function dump(): void
    {
        var_dump($this);
    }
}