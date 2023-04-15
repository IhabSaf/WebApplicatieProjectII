<?php

namespace FrameWork\Route;
class Redirect {
    public function toUrl(string $route): void
    {
        header("Location: ". $route);
    }
}