<?php

namespace FrameWork\Database;

use FrameWork\Database\Mapping;

class EntityManger implements EntityManagerInterface
{
    public function __construct(private DatabaseConnection $db) {

    }

    public function getEntity(string $entityClass): Mapping
    {
        return new $entityClass($this->db);
    }

    public function getDbConnection()
    {
        return $this->db;
    }
}
