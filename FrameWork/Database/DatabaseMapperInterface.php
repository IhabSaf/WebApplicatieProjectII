<?php

namespace FrameWork\database;
/**
 * @webTech2:
 *
 *  @INHOUD:
 *          Deze interface geeft een overzicht over wat de Mapping klasse inhoudt.
 */

interface DatabaseMapperInterface
{
    public function setAttribute(string $name, $value);
    public function getAttribute(string $name);
    public function toDatabaseArray(): array;
    public function save(): bool;
    public function update(array $criteria): bool;
    public function getTable(): string;
    public function findby(string $column): array;
    public function find(array $criteria): ?static;
    public function findAll(array $criteria = null): array;

}