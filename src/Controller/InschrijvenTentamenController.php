<?php

namespace src\Controller;

use FrameWork\Attribute\Roles;
use FrameWork\Database\EntityManger;
use FrameWork\Interface\RequestInterface;
use src\Model\Tentamen;
use src\Model\UserTentamen;

class InschrijvenTentamenController
{
    public function __construct(private EntityManger $entityManager){}

    #[Roles(['student', 'docent', 'admin'])]
    public function inschrijven(RequestInterface $request){
        // breng alle tenameten van de database
        $alleTentamen = $this->entityManager->getEntity(Tentamen::class)->findby('name');

        if ($request->isPost()) {
            //haal de data vanuit de form uit.
            $gekozenTenemenName = $request->getPostByName('tentamen');

            //Zoek het tentamen id van de betrefende tentamen name.
            $gekozenTenemenId = $this->entityManager->getEntity(Tentamen::class)->find(['name' => $gekozenTenemenName])->getId();

            // maak een nieuw object en stuur hem even naar de database.
            $nieuweInschrijving = new UserTentamen($this->entityManager->getDbConnection());
            $nieuweInschrijving->setId(null);
            $nieuweInschrijving->setUserId($request->getSessionValueByName('user_id'));
            $nieuweInschrijving->setTentamenId($gekozenTenemenId);
            $nieuweInschrijving->save();

        }
        //return array met alle tentamen naar de html pagina.
        return ['showTentamen' => $alleTentamen ];
    }
}