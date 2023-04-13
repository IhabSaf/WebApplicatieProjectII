<?php

namespace src\Controller;

use FrameWork\Attribute\Roles;
use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\security\CurrentUser;
use src\Model\Tentamen;
use src\Model\UserInschrijvingen;

class InschrijvenTentamenController
{
    #[Roles(['student', 'docent', 'admin'])]
    public function inschrijven(Request $request){


        $entityManager = new EntityManger();
        // breng alle tenameten van de database
        $alleTentamen = $entityManager->getEntity(Tentamen::class)->findby('name');


        if ($request->isPost()){

            //haal de data vanuit de form uit.
            $gekozenTenemenName = $request->getPostByName('tentamen');

            //Zoek het tentamen id van de betrefende tentamen name.
            $gekozenTenemenId = $entityManager->getEntity(Tentamen::class)->find(['name' => $gekozenTenemenName])->getId();


            // maak een nieuw object en stuur hem even naar de database.
            $nieuweInschrijving = new UserInschrijvingen();
            $nieuweInschrijving->setId(29);
            $nieuweInschrijving->setUserId(CurrentUser::get_user_id());
            $nieuweInschrijving->setTentamenId($gekozenTenemenId);
            $nieuweInschrijving->save();

        }

        //return array met alle tentamen naar de html pagina.
        return ['showTentamen' => $alleTentamen ];

    }

}