<?php

namespace src\Controller;

use FrameWork\Database\EntityManger;
use FrameWork\HTTP\Request;
use FrameWork\Interface\RequestInterface;
use src\Model\Tentamen;
use src\Model\User;
use src\Model\UserTentamen;



class GiveCijferController
{
    private $entityManager;
    private $alleVakkenID = [];

    public function __construct()
    {
        $this->entityManager = new EntityManger();
        $this->alleVakkenID = array();
    }

    public function findStudentForm(RequestInterface $request)
    {
        $students = $this->entityManager->getEntity(User::class)->findAll(['rolId' => 3]);
        $array = [];
        foreach ($students as $student) {
            $array[$student->getId()] = $student->getName();
        }

        return ['students' => $array];
    }

    public function addStudentGrade(RequestInterface $request)
    {
        // als post dan sla cijfer op
        if($request->isPost()){
            $studentId = $request->getPostByName('studentId');
            $tentamenId = $request->getPostByName("tentamenId");
            $cijfer = $request->getPostByName('cijfer');
            $this->addGrade($studentId, $tentamenId, $cijfer);
            return ['success' => true];
        }

        $studentNummer = $request->getGetByName('StudentNummer');

        //haal alle objecten van de database die matchen met die student number.
        $findStudentInschrijvingen = $this->entityManager->getEntity(UserTentamen::class)
            ->findAll(['userId' => $studentNummer]);

        //maak een array met het tentamen nummer waar de student zich geschreven heeft.
        foreach ($findStudentInschrijvingen as $studentVakken) {
            $this->alleVakkenID[] = $studentVakken->getTentamenId();
        }

        $vakken = array();
        //haal de namen van de vakken waar de student zich heeft ingeschreven.
        foreach ($this->alleVakkenID as $id){
            $vakken [$id] = $this->entityManager->getEntity(Tentamen::class)
                ->find(['id' => $id])->getName();
        }

        return ['vakken' => $vakken, 'studentId' => $studentNummer];
    }

    public function addGradeInfo(RequestInterface $request){
        return [];
    }

    public function addGrade(string $studentId, string $tentamenId, string $cijfer) {
        $userTentamen = $this->entityManager->getEntity(UserTentamen::class)
            ->find(['userId' => $studentId, 'tentamenId' => $tentamenId]);

        $userTentamen->setCijfer($cijfer);
        $userTentamen->update(['userId' => $studentId, 'tentamenId' => $tentamenId]);
    }
}