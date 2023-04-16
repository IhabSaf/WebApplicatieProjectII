<?php
namespace FrameWork\Interface;
interface ResponseInterface
{
    function addHeader(string $name, string $value): void;
    function setHeader(string $name, string $value): void;
    function getHeader(string $key): ?string;
    function allHeaders(): HeaderInterface;
    function setStatusCode(int $statusCode): void;
    function setContent(string $body): void;
    function send(): void;
    function dump(): void;
}