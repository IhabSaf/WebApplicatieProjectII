<?php

namespace src\Controller;


use FrameWork\database\DatabaseConnection;
use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\Interface\RequestInterface;
use FrameWork\Route\Redirect;
use src\Model\Rol;
use src\Model\User;

class LoginController
{
    public function __construct(private RequestInterface $request, private EntityManger $entityManger){}

    public function loginUser()
    {
        //Haal values uit de request session of null als deze niet bestaan
        $sessionId = $this->request->getSessionValueByName('user_id');
        $sessionUsername = $this->request->getSessionValueByName('user_name');

        //check eerst of er een post request is.
        if ($this->request->isPost()){

            //haal de data van de form
            $email = $this->request->getPostByName('username');
            $password = $this->request->getPostByName('password');

            //haal de gegevens van de gebruiker vanuit de database
            $getUserCred = $this->entityManager->getEntity(User::class)->find(['email' => $email]);
            if(!isset($getUserCred)){
                $getUserCred = $this->entityManager->getEntity(User::class)->find(['name' => $email]);
            }
            $findRole =  $this->entityManager->getEntity(Rol::class)->find(['id' => $getUserCred->getRolId()]);


            // Verificatie of het wachtwoord correct is met wat in de database staat.
            // Als er geen sprake van een just wachtwoord of email dan weiger de inlog, anders login en start een sessie en sla de gegevens van de gebruikers op.
        if (!$getUserCred->getEmail() || !password_verify($password, $getUserCred->getPassword())) {
            echo '<div>Incorrect username or password.</div>';
            $this->request->redirect->toUrl('/home');
            exit();
        }

        else{
            // Als de inloggegevens geldig zijn dan begin een session
            $this->request->setSessionValueByName('user_id', $getUserCred->getId());
            $this->request->setSessionValueByName('user_name', $getUserCred->getName());
            $this->request->setSessionValueByName('user_role', $findRole->getName());
            $this->request->saveSession();
            $this->request->redirect->toUrl('/home');
            exit();
        }

        }

        return [];
    }

    public function logout()
    {
        // Destroy de sessie wanneer de gebruiker op 'logout' drukt.
        $this->request->endSession();
        return[];
    }

}