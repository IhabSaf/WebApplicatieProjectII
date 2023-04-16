<?php

namespace FrameWork\Route;
/**
 * @webTech2:
 *
 *  @INHOUD:
 *          Deze interface geeft een overzicht over wat de Route klass bevat.
 */

interface RouteInterface {

    public function addRoute(string $name, string $controller, string $route, array $paramDefaults = null): void;

    public function isValidRoute(string $route): bool;

    public function getRoute(string $route): ?object;

    public function allRoutes(): array;
}
