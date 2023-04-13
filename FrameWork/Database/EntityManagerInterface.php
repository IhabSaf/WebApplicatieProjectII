<?php
namespace FrameWork\Database;

use FrameWork\database\Mapping;

interface EntityManagerInterface
{
    public function getEntity(string $entityClass): Mapping;
}
