<?php
namespace FrameWork\Interface;

interface IRequest
{
    static function makeWithGlobals(): IRequest;
    function getServer(): array;
    function getGet(): array;
    function getGetSecure(): array;
    function getCookieByName(string $name): string;
    function getGetParam(string $name): string;
    function getPost(string $name): string;
    function getPathInfo(): string;
    function dump(): void;
}