<?php

namespace src\Controller;

use FrameWork\HTTP\isRequest;
use FrameWork\HTTP\Request;
use src\Model\Rol;
use src\Model\User;

class LoginController
{

    public function loginUser(Request $request)
    {
        //Deceleratie voor variabelen die later worden gebruiken om de gegevens van de gebruiken op te slaan.
        $sesstionId = null;
        $sesstionUsername = null;

        //check eerst of er een post request is.
        if (isRequest::post()){

            //haal de data van de form
            $email = $request->getPostByName('username');
            $password = $request->getPostByName('password');

            //haal de gegevens van de gebruiker vanuit de database
            $getUserCred = User::find(['email' => $email]);
            $findRole =  Rol::find(['id' => $getUserCred->getRolId()]);

            // Verificatie of het wachtwoord correct is met wat in de database staat.
            // Als er geen sprake van een just wachtwoord of email dan weiger de inlog, anders login en start een sessie en sla de gegevens van de gebruikers op.
        if (!$getUserCred || !password_verify($password, $getUserCred->getPassword())) {
            echo '<div>Incorrect username or password.</div>';
            header('Location: /login');}

        else{
            // Als de inloggegevens geldig zijn dan begin een session
            session_start();
            $_SESSION['user_id'] = $getUserCred->getId();
            $_SESSION['user_Name'] = $getUserCred->getName();
            $_SESSION['user_rol'] = $findRole->getName();

            $sesstionId = $_SESSION['user_id'];
            $sesstionUsername = $_SESSION['user_Name'];
            header('Location: /home');}

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
        // Destroy de sessie wanneer de gebruiker op 'logout' drukt.
        session_unset();
        session_destroy();
        return[];
    }

}