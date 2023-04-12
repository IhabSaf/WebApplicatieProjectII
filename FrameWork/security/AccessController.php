<?php

namespace FrameWork\security;
use FrameWork\Attribute;
use ReflectionClass;

/**
 * @webTech2:
 *
 *  @INHLUD:
 *          Klaase: @AccessController, deze klasse bestaat uit 1 method die altijd boolean terug geeft.
 *          De bedoeling van deze method @checkAccess() om een boolean terug te geven nadat de gebruiker in het identificatie-proces loopt.
 *  @GEBRUIK: identificatie van een gebruiker, toegang checken of die gebruiker mag op een bepaalde controller binnen dit project.
 *
 */

class AccessController
{

    /**
     * @param string|null $rol
     * @param string $controllerName
     * @param string $methodName
     * @return bool
     * @throws \ReflectionException
     */
    public static function checkAccess(?string $rol, string $controllerName, string $methodName): bool
    {
        // neem de aangegeven controller en de method door met gebruik van reflection klasse, en dan haal de attributen (roles)
        $reflectionClass = new ReflectionClass($controllerName);
        $reflectionMethod = $reflectionClass->getMethod($methodName);
        $rolesAttributes = $reflectionMethod->getAttributes(\FrameWork\Attribute\Roles::class)[0]?? null;

        //als is er geen attributen vastgesteld op een controller dat betekent iedereen mag binnen.
        if (empty($rolesAttributes)) {
            return true;
        }

        // verzamel alle rollen vanuit de attributen binnen een array
        $mydata = $rolesAttributes->newInstance()->roles;

        // check of aangegeven rol uit de parameters bestaat in die $data array, return true of die gebruiker wel in de array
        if (in_array($rol, $mydata)) {
            return true;
        }

        // als de gebruiker niet in de array dan krijgt hij geen toegang tot de aangegeven methode.
        return false;
    }

}