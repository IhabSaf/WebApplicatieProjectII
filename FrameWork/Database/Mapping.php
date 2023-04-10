<?php

namespace FrameWork\database;

use FrameWork\Attribute\Column;
use PDO;
use ReflectionClass;

class Mapping {
    private array $data = [];
    private string $table;
    private DatabaseConnection $db;

    public function __construct(array $data = [])
    {
        $this->data = $data;
        $this->table = $this->getTable();
        $this->db = new DatabaseConnection();
    }

    public function setAttribute(string $name, $value)
    {
        $this->data[$name] = $value;
    }

    public function getAttribute(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function toDatabaseArray(): array
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();

        $data = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $columnAttribute = $property->getAttributes(Column::class)[0] ?? null;
            if ($columnAttribute) {
                $columnName = $columnAttribute->newInstance()->name;
                $data[$columnName] = $this->getAttribute($propertyName);
            }
        }

        return $data;
    }

    public function save(): bool
    {
        $data = $this->toDatabaseArray();
        $columns = implode(',', array_keys($data));
        $values = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $commit = $this->db->getConnector()->prepare($sql);

        $i = 1;
        foreach ($data as $value) {
            $commit->bindValue($i++, $value);
        }

        return $commit->execute();
    }



    private function getPropertyName(string $columnName): string
    {
        $reflection = new ReflectionClass($this);
        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            $columnAttribute = $property->getAttributes(Column::class)[0] ?? null;
            if ($columnAttribute && $columnAttribute->newInstance()->name === $columnName) {
                return $property->getName();
            }
        }
        return '';
    }

    private function getTable(): string
    {
        $classParts = explode('\\', static::class);
        $className = end($classParts);
        return strtolower($className) . '';
    }

    public function select(string $query, array $bindValues = []): array
    {
        $stmt = $this->db->getConnector()->prepare($query);
        $i = 1;
        foreach ($bindValues as $value) {
            $stmt->bindValue($i++, $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
