<?php

class Response
{
    private int $statusCode;
    private array $headers;
    private string $body;
    private const ALLOWED_STATUS_CODES = [
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

    public function __construct(string $body, array $header=[], int $statusCode=200)
    {
        $this->statusCode = $statusCode;
        $this->headers = $header;
        $this->body =$body;
    }

    public function addHeader(string $name, string $value): void
    {
        $this->headers[$name][] = $value;
    }

    public function setHeader(string $name, string $value): void
    {
        $this->headers[$name] = [$value];
    }

    public function changeStatusCode(int $statusCode): void
    {
        if(in_array($statusCode, array_keys(self::ALLOWED_STATUS_CODES)))
        {
            $this->statusCode = $statusCode;
        }
    }

    public function send(): void
    {
        var_dump($this);
    }
}