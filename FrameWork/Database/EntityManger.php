<?php

namespace FrameWork\Database;

class EntityManger implements EntityManagerInterface
{
    public function __construct(#[Argument(connectorClass: "PDO", exceptionClass: "PDOException")] private DatabaseConnection $db) {

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
