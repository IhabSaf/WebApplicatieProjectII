<?php

namespace src\Controller;


use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\Interface\RequestInterface;
use FrameWork\Route\Redirect;
use src\Model\Rol;
use src\Model\User;

class LoginController
{
    public function __construct(){}

    public function loginUser(Request $request)
    {
        $entityManager = new EntityManger();

        //Haal values uit de request session of null als deze niet bestaan
        $sessionId = $request->getSessionValueByName('user_id');
        $sessionUsername = $request->getSessionValueByName('user_name');

        //check eerst of er een post request is.
        if ($request->isPost()){

            //haal de data van de form
            $email = $request->getPostByName('username');
            $password = $request->getPostByName('password');

            //haal de gegevens van de gebruiker vanuit de database
            $getUserCred = $entityManager->getEntity(User::class)->find(['email' => $email]);
            $findRole =  $entityManager->getEntity(Rol::class)->find(['id' => $getUserCred->getRolId()]);


            // Verificatie of het wachtwoord correct is met wat in de database staat.
            // Als er geen sprake van een just wachtwoord of email dan weiger de inlog, anders login en start een sessie en sla de gegevens van de gebruikers op.
        if (!$getUserCred->getEmail() || !password_verify($password, $getUserCred->getPassword())) {
            echo '<div>Incorrect username or password.</div>';
            header('Location: /home');
            exit();
        }

        else{
            // Als de inloggegevens geldig zijn dan begin een session
            $request->setSessionValueByName('user_id', $getUserCred->getId());
            $request->setSessionValueByName('user_name', $getUserCred->getName());
            $request->setSessionValueByName('user_role', $findRole->getName());
            $request->saveSession();
            header('Location: /home');
            exit();
        }

        }

        return [];
    }

    public function logout(RequestInterface $request)
    {
        // Destroy de sessie wanneer de gebruiker op 'logout' drukt.
        $request->endSession();
        return[];
    }

}