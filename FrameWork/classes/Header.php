<?php

class Header {
    public function __construct()
    {

    }

    public function addHeader(string $header, bool $replace = true): void
    {
        header($header, $replace);
    }

    public function removeHeader(string $header): void
    {
        header_remove($header);
    }

    public function checkHeaders()
    {
        var_dump(headers_list());
    }

    public function hasHeader($header)
    {
        return in_array($header, headers_list());
    }
}