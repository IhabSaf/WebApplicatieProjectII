<?php

namespace src\Controller;

use FrameWork\HTTP\isRequest;
use FrameWork\HTTP\Request;
use FrameWork\Interface\IRequest;
use src\Model\Tentamen;
use src\Model\UserInschrijvingen;
use src\Model\UserTentamen;

class GiveCijfer
{
    private $alleVakkenID = [];

    public function invulCijfer(Request $request){

        $alleVakkenNamen = null;
        if(isRequest::post()){
            $alleVakkenNamen =array();
            //haal de namen van de vakken waar de student zich heeft ingeschreven.
            for ($index = 0; sizeof($this->alleVakkenID) > $index; $index++){
                $alleVakkenNamen []= Tentamen::find(['name' => $this->alleVakkenID[$index]])->getName();}

            var_dump($alleVakkenNamen);
            var_dump($_POST);

            $gekozenVak = $request->getPostByName("vak");
            $ingevuldeCijfer = $request->getPostByName('cijfer');

            $nameVanDevak = Tentamen::find(['id' => $gekozenVak])->getId();

            $requestStudent = new UserTentamen();
            $requestStudent->setId(5);
            $requestStudent->setTentamenId($nameVanDevak);
            $requestStudent->setCijfer($ingevuldeCijfer);
//            $requestStudent->setUserId($StudentNummer);
        }


        return [ 'vakken' => $alleVakkenNamen];

    }


    public function findStudentForm(IRequest $request){
        if(isRequest::post()){

            //convert the value to int.
            $StudentNummer = intval($request->getPostByName('StudentNummer'));

            //haal alle objecten van de database die matchen met die student number.
            $findStudentinschrijvingen = UserInschrijvingen::findAll(['userId' => $StudentNummer]);

            //maak een array met het tentamen nummer waar de student zich geschreven heeft.
            foreach ($findStudentinschrijvingen as $studentVakken) {
                $this->alleVakkenID[] = $studentVakken->getTentamenId();
            }
        }

        return [];
    }

    public function niks(){
        return[];
    }


}