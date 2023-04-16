<?php

namespace FrameWork\Route;

/**
 * @webTech2:
 *
 *  @INHOUD:
 *          Deze interface geeft een overzicht over wat de RouteObject klass bevat.
 */

interface RouteObjectInterface
{
    public function getName(): string;

    public function getFullUrl(): string;

    public function getBaseUrl(): string;

    public function getUrlParams(): ?array;

    public function setUrlParams($urlParams): void;

    public function setUrlParamsWithoutDefault($route): void;

    public function hasParams(): bool;

    public function getReturnType(): string;

    public function getController();

    public function getMethod();

}
