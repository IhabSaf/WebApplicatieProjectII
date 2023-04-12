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


    public  function getTable(): string
    {
        $classParts = explode('\\', static::class);
        $className = end($classParts);
        return strtolower($className) . '';
    }

//    public static function find(string $conditions): ?static
//    {
//        $db = new DatabaseConnection();
//        $table = (new static())->getTable();
//        $entityClass = get_called_class();
//
//
//
//
//        $stmt = $db->getConnector()->prepare("SELECT * FROM $table");
//        $stmt->execute($stmt);
//
//        $data = $stmt->fetch(PDO::FETCH_ASSOC);
//        if (!$data) {
//            return null;
//        }
//        $instances = new $entityClass($data);
//
//        return $instances;
//    }

// return object this works
//    public static function find(): array
//    {
//        $db = new DatabaseConnection();
//
//        $table = (new static())->getTable();
//
//        $stmt = $db->getConnector()->prepare("SELECT * FROM $table");
//        $stmt->execute();
//        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//        $instances = [];
//        foreach ($data as $row) {
//            $instance = new static($row);
//            $instances[] = $instance;
//        }
//
//        return $instances;
//    }


//this return only the values of clomun
    public static function findby(string $column): array
    {
        $db = new DatabaseConnection();

        $table = (new static())->getTable();

        $stmt = $db->getConnector()->prepare("SELECT $column FROM $table");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $instances = [];
        foreach ($data as $row) {
            $instances[] = $row[$column];
        }
        return $instances;
    }
    public static function find(array $criteria): ?static
    {
        $db = new DatabaseConnection();
        $table = (new static())->getTable();
        $whereClauses = [];

        foreach ($criteria as $attribute => $value) {
            $whereClauses[] = "{$attribute} = ?";
        }

        $whereClause = implode(' AND ', $whereClauses);
        $sql = "SELECT * FROM {$table} WHERE {$whereClause} LIMIT 1";
        $statement = $db->getConnector()->prepare($sql);

        $i = 1;
        foreach ($criteria as $value) {
            $statement->bindValue($i++, $value);
        }

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new static($result);
        } else {
            return null;
        }
    }


    public static function findByEmail(string $email): ?static
    {
        return static::find(['email' => $email]);
    }


 }
