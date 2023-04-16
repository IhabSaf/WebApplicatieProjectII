<?php

namespace src\Controller;

use FrameWork\Attribute\Roles;
use FrameWork\Database\EntityManagerInterface;
use FrameWork\Database\EntityManger;
use FrameWork\Interface\RequestInterface;
use FrameWork\Route\Redirect;
use src\Model\Tentamen;
use src\Model\UserTentamen;

class InschrijvenTentamenController
{
    public function __construct(#[Service(EntityManger::class)] private EntityManagerInterface $entityManager, private Redirect $redirect){}

    #[Roles(['student', 'docent', 'admin'])]
    public function inschrijven(RequestInterface $request){
        // breng alle tentamen van de database
        $alleTentamen = $this->entityManager->getEntity(Tentamen::class)->findAll();
        $alreadyExists = $this->entityManager->getEntity(UserTentamen::class)->findAll(['userId' => $request->getSessionValueByName('user_id')]);
        $noTentamens = false;
        $tentamenIds = [];
        foreach ($alreadyExists as $a){
            $tentamenIds[] =  $a->getTentamenId();
        }
        $allowedTentamens = [];
        foreach ($alleTentamen as $tentamen) {
            if(!in_array($tentamen->getId(), $tentamenIds)){
                $allowedTentamens[] = $tentamen->getName();
            }
        }
        if(count($allowedTentamens) === 0){
            $noTentamens = true;
        }
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
            $this->redirect->toUrl('/home');
        }
        //return array met alle tentamen naar de html pagina.
        return ['showTentamen' => $allowedTentamens, 'noTentamens' => $noTentamens ];
    }
}