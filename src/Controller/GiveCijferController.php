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

    public function __construct(private RequestInterface $request, private EntityManger $entityManager){}

    public function findTentamenForm()
    {
        if($this->request->hasGet('Tentamen')){
            $tentamenId = $this->request->getGetByName('Tentamen');
            $this->request->redirect->toUrl('/addStudentGrade/' . $tentamenId);
        }

        if($this->request->getSessionValueByName('user_role') === 'admin'){
            $tentamens = $this->entityManager->getEntity(Tentamen::class)->findAll();
        } else{
            $tentamens = $this->entityManager->getEntity(Tentamen::class)->findAll(['docentId' => $this->request->getSessionValueByName('user_id')]);
        }
        $array = [];
        foreach ($tentamens as $tentamen) {
            $array[$tentamen->getId()] = $tentamen->getName();
        }

        return ['tentamens' => $array];
    }

    public function addStudentGrade()
    {
        // als post dan sla cijfer op
        if($this->request->isPost()){
            $studentId = $this->request->getPostByName('studentId');
            $tentamenId = $this->request->getPostByName("tentamenId");
            $cijfer = $this->request->getPostByName('cijfer');
            $this->addGrade($studentId, $tentamenId, $cijfer);
            return ['success' => true];
        }

        $tentamenId = $this->request->getAttributeByName("id");

        //haal alle objecten van de database die matchen met die student number.
        $studentTentamens = $this->entityManager->getEntity(UserTentamen::class)
            ->findAll(['tentamenId' => $tentamenId]);

        //maak een array met het tentamen nummer waar de student zich geschreven heeft.
        $ids = [];
        foreach ($studentTentamens as $studentTentaman) {
            $ids[] = $studentTentaman->getUserId();
        }

        $students = array();
        //haal de namen van de vakken waar de student zich heeft ingeschreven.
        foreach ($ids as $id){
            $students[$id] = $this->entityManager->getEntity(User::class)
                ->find(['id' => $id])->getName();
        }

        return ['studenten' => $students, 'tentamenId' => $tentamenId];
    }

    public function addGradeInfo(){
        return [];
    }

    public function addGrade(string $studentId, string $tentamenId, string $cijfer) {
        $userTentamen = $this->entityManager->getEntity(UserTentamen::class)
            ->find(['userId' => $studentId, 'tentamenId' => $tentamenId]);

        $userTentamen->setCijfer($cijfer);
        $userTentamen->update(['userId' => $studentId, 'tentamenId' => $tentamenId]);
    }
}