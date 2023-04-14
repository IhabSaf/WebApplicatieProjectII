<?php
namespace FrameWork\Interface;

interface RequestInterface
{
    static function makeWithGlobals(): RequestInterface;
    function getServer(): array;
    function getGet(): array;
    function getGetSecure(): array;
    function getCookieByName(string $name): ?string;
    function getPostByName(string $name): ?string;
    function getPost(): array;
    function getPostSecure(): array;
    function getPathInfo(): string;
    function dump(): void;
}