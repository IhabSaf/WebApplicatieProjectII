<?php

namespace FrameWork\HTTP;

class isRequest
{
    public static function post(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

}