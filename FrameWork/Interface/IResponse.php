<?php
namespace FrameWork\Interface;
interface IResponse
{
    function addHeader(string $name, string $value): void;
    function setHeader(string $name, string $value): void;
    function setStatusCode(int $statusCode): void;
    function setContent(string $body): void;
    function send(): void;
    function dump(): void;
}