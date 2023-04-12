<?php

namespace src\Controller;

use FrameWork\HTTP\isRequest;
use FrameWork\HTTP\Request;
use FrameWork\Attribute\Roles;
use src\Model\Rol;
use src\Model\User;

class RegistrationController
{

    #[Roles(roles: ['admin'])]
    public function registration(Request $request)
    {
        // haal de rols op vanuit de database
        $data = Rol::findby('name');

        // check of de method post is, haal de data daarna vanuit de form
        if (isRequest::post()){
            $name = $request->getPostByName('name');
            $email = $request->getPostByName('email');
            $password = $request->getPostByName('password');
            $role_name = $request->getPostByName('role');

            //find de key van de betrefende rol name
            $id_rol = Rol::find(['name' => $role_name]);

            //maak nieuwe gebruiker, en sla de gegevens op in de database.
            $user = new User();
            $user->setId(43);
            $user->setName($name);
            $user->setRolId($id_rol->getId());
            $user->setPassword($password);
            $user->setEmail($email);
            $user->save();
        }

          return ['roles' => $data];
    }

}

