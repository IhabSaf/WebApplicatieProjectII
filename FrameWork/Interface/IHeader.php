<?php
namespace FrameWork\Interface;
interface IHeader
{
function addHeader(string $header, bool $replace = true): void;
function removeHeader(string $header): void;
function checkHeaders(): void;
function hasHeader(string $header): bool;
}