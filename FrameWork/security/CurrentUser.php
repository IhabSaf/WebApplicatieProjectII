<?php

namespace FrameWork\security;

class CurrentUser
{
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