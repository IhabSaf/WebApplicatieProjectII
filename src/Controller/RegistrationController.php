<?php

namespace src\Controller;

use FrameWork\HTTP\Request;
use FrameWork\Attribute\Role;
use src\Model\User;


class RegistrationController
{

    public function __construct( )
    {

    }

    #[Role(roles: ['gasttt'])]
    public function registration(Request $request)
    {
        $name = null;
        $email = null;
        $password = null;

        if ($request->getServer()['REQUEST_METHOD'] === 'POST') {
            $name = $request->getPostByName('name');
            $email = $request->getPostByName('email');
            $password = $request->getPostByName('password');

            $user = new User();
            $user->setId(10);
            $user->setName($name);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->save();
        }

          return [$name, $email, $password ];
    }

}

