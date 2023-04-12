<?php

namespace src\Controller;

use FrameWork\Attribute\Roles;
use FrameWork\HTTP\isRequest;
use FrameWork\HTTP\Request;
use FrameWork\security\CurrentUser;
use src\Model\Tentamen;
use src\Model\UserInschrijvingen;

class InschrijvenTentamenController
{
    #[Roles(['student', 'docent', 'admin'])]
    public function inschrijven(Request $request){

        // breng alle tenameten van de database
        $alleTentamen = Tentamen::findby('name');

        if (isRequest::post()){

            //haal de data vanuit de form uit.
            $gekozenTenemenName = $request->getPostByName('tentamen');

            //Zoek de tentamen id van de betrefende tentamen name.
            $gekozenTenemenId = Tentamen::find(['name' => $gekozenTenemenName]);

            // maak een nieuwe object en stuur hem even naar de database.
            $nieuweInschrijving = new UserInschrijvingen();
            $nieuweInschrijving->setId(28);
            $nieuweInschrijving->setUserId(CurrentUser::get_user_id());
            $nieuweInschrijving->setTentamenId($gekozenTenemenId->getId());
            $nieuweInschrijving->save();

        }

        //return array met alle tentamen naar de html pagina.
        return ['showTentamen' => $alleTentamen ];

    }

}