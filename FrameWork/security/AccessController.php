<?php

namespace FrameWork\security;
use FrameWork\Attribute;
use ReflectionClass;


class AccessController
{

    public static function checkAccess(?string $rol, string $controllerName, string $methodName)
    {
        $controller = new $controllerName();
        $reflectionClass = new ReflectionClass($controllerName);
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $rolesAttributes = $reflectionMethod->getAttributes(\FrameWork\Attribute\Roles::class)[0]?? null;

        if (empty($rolesAttributes)) {

            return true;
        }


            $mydata = $rolesAttributes->newInstance()->roles;

            if (in_array($rol, $mydata)) {
                return true;
        }

        return false;
    }

}