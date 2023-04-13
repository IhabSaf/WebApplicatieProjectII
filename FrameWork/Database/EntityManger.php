<?php

namespace FrameWork\Database;

use FrameWork\Database\Mapping;

class EntityManger implements EntityManagerInterface
{
    public function getEntity(string $entityClass): Mapping
    {
        return new $entityClass();
    }
}
