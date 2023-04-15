<?php

namespace FrameWork\Database;

interface EntityManagerInterface
{
    public function getEntity(string $entityClass): Mapping ;
}
