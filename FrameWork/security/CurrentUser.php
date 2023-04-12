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
}