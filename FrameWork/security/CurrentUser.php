<?php

namespace FrameWork\security;

/**
 * @webTech2:
 *
 *  @INHLUD:
 *          Binnen deze klasse is er een static method. (static is omdat er geen een object hoeft gemaakt te worden)
 *          De bedoeling van deze method @get_user_id() om de id van de ingelogde user op te halen.
 *  @GEBRUIK: dit wordt gebruik vaak bij elke controller wannneer er een handiling van een post request plaats vindt.
 *
 */

class CurrentUser
{

    /**
     * @return mixed|null
     */
    public static function get_user_id()
    {
        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            return $user_id;
        } else {
            return null;
        }

    }

    public static function get_user_rol()
    {
        if (isset($_SESSION['user_rol'])) {
            $user_id = $_SESSION['user_rol'];
            return $user_id;
        } else {
            return null;
        }

    }

    public static function isAdmin(): bool
    {
        if(self::get_user_rol() == 'admin'){
            return true;
        }

        return false;
    }


    public static function isDocent(): bool
    {
        if(self::get_user_rol() == 'docent'){
            return true;
        }

        return false;
    }


    public static function isStudent(): bool
    {
        if(self::get_user_rol() == 'student'){
            return true;
        }
        return false;
    }

    public static function isInloged(){

        if(self::isStudent() || self::isAdmin() || self::isDocent())
        {
            return true;
        }

        return false;

    }


}