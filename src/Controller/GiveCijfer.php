<?php

namespace src\Controller;

use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\Interface\IRequest;
use src\Model\Tentamen;
use src\Model\User;
use src\Model\UserInschrijvingen;
use src\Model\UserTentamen;



class GiveCijfer
{
    private $entityManager;
    private $alleVakkenID = [];

    public function __construct()
    {
        $this->entityManager = new EntityManger();
        $this->alleVakkenID = array();
    }

    public function findStudentForm(Request $request)
    {
        var_dump('test');

            $studentNummer = $request->getGet()['studentNummer'];
//                intval($request->getPostByName('studentNummer'));

            //haal alle objecten van de database die matchen met die student number.
            $findStudentInschrijvingen = $this->entityManager->getEntity(UserInschrijvingen::class)
                ->findAll(['userId' => $studentNummer]);

            //maak een array met het tentamen nummer waar de student zich geschreven heeft.
            foreach ($findStudentInschrijvingen as $studentVakken) {
                $this->alleVakkenID[] = $studentVakken->getTentamenId();
            }
            var_dump($this->alleVakkenID);
            var_dump($this->alleVakkenID);

            $alleVakkenNamen = array();
            //haal de namen van de vakken waar de student zich heeft ingeschreven.
            for ($index = 0; sizeof($this->alleVakkenID) > $index; $index++) {
                $alleVakkenNamen [] = $this->entityManager->getEntity(Tentamen::class)
                    ->find(['id' => $this->alleVakkenID[$index]])->getName();
            }
            var_dump($alleVakkenNamen);


        return ['alleVakkenNamen' => $alleVakkenNamen];
    }

    public function invulCijfer(Request $request)
    {
        if($request->isPost()){
            var_dump('hey');
            $gekozenVak = $request->getPostByName("vak");
            $ingevuldeCijfer = $request->getPostByName('cijfer');
            $nameVanDevak = $this->entityManager->getEntity(Tentamen::class)
                ->find(['id' => $gekozenVak])->getId();

            $requestStudent = new UserTentamen();
            $requestStudent->setTentamenId($nameVanDevak);
            $requestStudent->setCijfer($ingevuldeCijfer);
            $requestStudent->setUserId(22);
            $requestStudent->save();
        }

        return ['success' => true];
    }




}