<?php
namespace src\Controller;

use FrameWork\Database\EntityManger;
use FrameWork\Interface\RequestInterface;
use src\Model\Tentamen;
use src\Model\UserTentamen;

class ShowResultaatController
{
    public function __construct(private EntityManger $entityManager){}

    public function show(RequestInterface $request): array
    {
            // haal de resultten van alle vakken van de ingelogde student.
            $studentId = $request->getSessionValueByName('user_id');

            $studentTentamenId = $this->entityManager->getEntity(UserTentamen::class)->findAll(['userId' => $studentId]);

            $studentTentamen = [];
            foreach ($studentTentamenId as $tentamen) {
                $studentTentamen[] = [$tentamen->getTentamenId(), $tentamen->getCijfer()];
            }

            $alleVakkenNamen = [];
            //haal de namen van de vakken waar de student zich heeft ingeschreven.
            for ($index = 0; sizeof($studentTentamen) > $index; $index++) {
                $alleVakkenNamen [] = [$this->entityManager->getEntity(Tentamen::class)
                    ->find(['id' => $studentTentamen[$index][0]])->getName(), $studentTentamen[$index][1]];

            }
        return ['studentTentamen' => $alleVakkenNamen];
    }
}