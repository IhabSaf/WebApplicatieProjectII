<?php

namespace FrameWork\security;

interface AccessControllerInterFace
{

    public function checkAccess(?string $rol, string $controllerName, string $methodName);

}