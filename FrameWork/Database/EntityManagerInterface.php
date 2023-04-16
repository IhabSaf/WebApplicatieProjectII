<?php

namespace FrameWork\Database;

/**
 * @webTech2:
 *
 *  @INHOUD:
 *          Deze interface geeft een overzicht over wat de EntityManager inhoudt.
 */

interface EntityManagerInterface
{
    public function getEntity(string $entityClass): Mapping ;
}
