<?php

namespace src\Controller;

use FrameWork\Database\EntityManger;
use FrameWork\Attribute\Roles;
use FrameWork\Interface\RequestInterface;
use src\Model\Rol;
use src\Model\User;

class RegistrationController
{
    public function __construct(private RequestInterface $request, private EntityManger $entityManager){}

    #[Roles(roles: ['admin'])]
    public function registration()
    {


        // haal de rols op vanuit de database
        $data = $this->entityManager->getEntity(Rol::class)->findby('name');

        // check of de method post is, haal de data daarna vanuit de form
        if ($this->request->isPost()){
            $name = $this->request->getPostByName('name');
            $email = $this->request->getPostByName('email');
            $password = $this->request->getPostByName('password');
            $role_name = $this->request->getPostByName('role');

            //find de key van de betreffende rol name
            $id_rol = $this->entityManager->getEntity(Rol::class)->find(['name' => $role_name])->getId();

            //maak nieuwe gebruiker, en sla de gegevens op in de database.
            $user = new User($this->entityManager->getDbConnection());
            $user->setId(null);
            $user->setName($name);
            $user->setRolId($id_rol);
            $user->setPassword($password);
            $user->setEmail($email);
            $user->save();
        }

          return  ['roles' => $data];
    }

}

