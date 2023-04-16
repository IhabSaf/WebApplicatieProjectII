<?php

namespace FrameWork\security;

interface AccessControllerInterFace
{

    /**
     * @webTech2:
     *
     *  @INHOUD:
     *          Deze interface geeft een overzicht over wat de AccessController inhoudt.
     */

    public function checkAccess(?string $rol, string $controllerName, string $methodName);

}