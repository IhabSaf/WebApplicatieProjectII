<?php

namespace src\Controller;


use FrameWork\HTTP\Request;
use src\Model\Rol;
use src\Model\User;

class LoginController
{

    public function loginUser(Request $request)
    {
        //De
        $sesstionId = null;
        $sesstionUsername = null;

        if ($request->getServer()['REQUEST_METHOD'] === 'POST') {

            $email = $request->getPostByName('username');
            $password = $request->getPostByName('password');

            $getUserCred = User::find(['email' => $email]);

            $findRole =  Rol::find(['id' => $getUserCred->getRolId()]);




        if (!$getUserCred || !password_verify($password, $getUserCred->getPassword())) {
            echo '<div>Incorrect username or password.</div>';
            header('Location: /login');
        } else {
            // Als de inloggegevens geldig zijn dan begin een session
            session_start();
            $_SESSION['user_id'] = $getUserCred->getId();
            $_SESSION['user_Name'] = $getUserCred->getName();
            $_SESSION['user_rol'] = $findRole->getName();

            $sesstionId = $_SESSION['user_id'];
            $sesstionUsername = $_SESSION['user_Name'];
//            header('Location: /home');



        }
        }
        // Controleer of de sessievariabelen bestaan voordat ze worden gebruikt
        if (isset($_SESSION['user_id']) && isset($_SESSION['user_name'])) {
            $sessionId = $_SESSION['user_id'];
            $sessionUsername = $_SESSION['user_Name'];
        }
        return [ 'sesstionid' => $sesstionId, 'sesstionUserName' => $sesstionUsername];
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        return[];
    }

}