<?php
namespace src\Controller;

use FrameWork\Database\EntityManger;
use FrameWork\Interface\RequestInterface;
use FrameWork\Route\Redirect;
use src\Model\Tentamen;
use src\Model\User;
use src\Model\UserTentamen;



class GiveCijferController
{

    public function __construct(private EntityManger $entityManager, private Redirect $redirect){}

    public function findTentamenForm(RequestInterface $request)
    {
        if($request->hasGet('Tentamen')){
            $tentamenId = $request->getGetByName('Tentamen');
            $this->redirect->toUrl('/addStudentGrade/' . $tentamenId);
        }

        if($request->getSessionValueByName('user_role') === 'admin'){
            $tentamens = $this->entityManager->getEntity(Tentamen::class)->findAll();
        } else{
            $tentamens = $this->entityManager->getEntity(Tentamen::class)->findAll(['docentId' => $request->getSessionValueByName('user_id')]);
        }
        $array = [];
        foreach ($tentamens as $tentamen) {
            $array[$tentamen->getId()] = $tentamen->getName();
        }

        return ['tentamens' => $array];
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

        $tentamenId = $request->getAttributeByName("id");

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