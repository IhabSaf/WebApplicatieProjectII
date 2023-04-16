<?php
namespace FrameWork\Interface;

interface RequestInterface
{
    static function makeWithGlobals(): RequestInterface;
    function saveSession(): void;
    function getSession(): array;
    function getSessionValueByName(string $name): ?string;
    function setSessionValueByName(string $name, string $value): void;
    function endSession(): void;
    function setAttribute(string $name, string $value): void;
    function addAttributes(array $attributes): void;
    function getAttributeByName(string $name): ?string;
    function getServer(): array;
    function getServerByName(string $name): ?string;
    function getGet(): array;
    function getGetByName(string $name): ?string;
    function getGetSecure(): array;
    function hasGet(string $name): bool;
    function getCookieByName(String $name): ?string;
    function getPostByName(String $name): ?string;
    function getPost(): array;
    function getPostSecure(): array;
    function getPathInfo(): string;
    function isPost(): bool;
    function dump(): void;
}