<?php

namespace FrameWork\HTTP;

use FrameWork\Interface\HeaderInterface;

class Header implements HeaderInterface{

    public function addHeader(string $header, bool $replace = true): void
    {
        header($header, $replace);
    }

    public function removeHeader(string $header): void
    {
        if ($this->hasHeader($header)) {
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

    public function getHeader(string $key): ?string {
        foreach (headers_list() as $header){
            if (str_contains($header, $key)) {
                return $header;
            }
        }
        return null;
    }
}