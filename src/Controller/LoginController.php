<?php

namespace src\Controller;


use FrameWork\HTTP\Request;
use src\Model\Rol;
use src\Model\User;

class LoginController
{

    public function loginUser(Request $request)
    {

        if ($request->getServer()['REQUEST_METHOD'] === 'POST') {

            $email = $request->getPostByName('username');
            $password = $request->getPostByName('password');

            $getUserCred = User::find(['email' => $email]);
            $getUserRol = $getUserCred->getRolId();
            $findRole  = Rol::find(['id' => $getUserRol]);


        if (!$getUserCred || !password_verify($password, $getUserCred->getPassword())) {

            header('Location: /login');
        } else {
            // Als de inloggegevens geldig zijn dan begin een session
            session_start();
            $_SESSION['user_id'] = $getUserCred->getId();
            $_SESSION['user_Name'] = $getUserCred->getName();
            $_SESSION['user_rol'] = $findRole->getName();
            $sesstionId = $_SESSION['user_id'];
            $sesstionUsername = $_SESSION['user_Name'];

            header('Location: /home');

        }
        }
        return [ 'sesstionid' => $sesstionId, 'sesstionUserName' => $sesstionUsername];
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }

}