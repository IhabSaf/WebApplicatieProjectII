<?php

namespace src\Controller;

use FrameWork\Interface\IRequest;
use src\Model\User;
use FrameWork\App;

class RegistrationController
{

    private  $request;
    public function __construct(IRequest $request)
    {

        $this->request = $request;
    }

    public function registration( )
    {


        $name = $this->request->getPost('name');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');


        $user = new User();
        $user->setName('name', $name);
        $user->setPassword('password', $password);
        $user->setEmail('email', $email);
        if($user->save()){
            echo 'gelukt';
        }

          return [$name, $email, $password ];
    }

}

