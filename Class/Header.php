<?php
namespace FrameWork\Class;

use FrameWork\Interface\IHeader;

class Header implements IHeader{
    public function __construct()
    {

    }

    public function addHeader(string $header, bool $replace = true): void
    {
        header($header, $replace);
    }

    public function removeHeader(string $header): void
    {
        if($this->hasHeader($header)){
            header_remove($header);
        }
    }

    public function checkHeaders(): void
    {
        var_dump(headers_list());
    }

    public function hasHeader(string $header): bool
    {
        return in_array($header, headers_list());
    }
}