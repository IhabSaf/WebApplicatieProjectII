<?php

namespace src\Controller;

use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\Attribute\Roles;
use src\Model\Rol;
use src\Model\User;

class RegistrationController
{

    private $entityManager;
    public function __construct()
    {
        $this->entityManager = new EntityManger();
    }

    #[Roles(roles: ['admin'])]
    public function registration(Request $request )
    {


        // haal de rols op vanuit de database
        $data = $this->entityManager->getEntity(Rol::class)->findby('name');

        // check of de method post is, haal de data daarna vanuit de form
        if ($request->isPost()){
            $name = $request->getPostByName('name');
            $email = $request->getPostByName('email');
            $password = $request->getPostByName('password');
            $role_name = $request->getPostByName('role');

            //find de key van de betreffende rol name
            $id_rol = $this->entityManager->getEntity(Rol::class)->find(['name' => $role_name])->getId();

            //maak nieuwe gebruiker, en sla de gegevens op in de database.
            $user = new User();
            $user->setId(46);
            $user->setName($name);
            $user->setRolId($id_rol);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->save();
        }

          return  ['roles' => $data];
    }

}

