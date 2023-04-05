<?php
namespace FrameWork\HTTP;

use FrameWork\Interface\IHeader;
use FrameWork\Interface\IResponse;

class Response implements IResponse
{
    private int $statusCode;
    private IHeader $headers;
    private string $body;
    private const STATUS_CODES_TEXTS = [
        100 => "Continue",
        200 => "OK",
        201 => "Created",
        204 => "No Content",
        301 => "Moved Permanently",
        302 => "Found",
        303 => "See Other",
        307 => "Temporary Redirect",
        308 => "Permanent Redirect",
        400 => "Bad Request",
        401 => "Unauthorized",
        403 => "Forbidden",
        404 => "Not Found",
        418 => "I'm  a teapot",
        500 => "Internal Server Error",
        503 => "Service Unavailable"
    ];

    public function __construct(string $body = "", #[Service(Header::class)] IHeader $header = new Header(), int $statusCode= 200)
    {
        $this->statusCode = $statusCode;
        $this->headers = $header;
        $this->body = $body;
    }

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
        return $this->headers->getHeader($key);
    }
    public function setStatusCode(int $statusCode): void
    {
            $this->statusCode = $statusCode;
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

    public function allHeaders(): IHeader
    {
        return $this->headers;
    }
}