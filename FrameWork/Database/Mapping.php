<?php

namespace FrameWork\database;

use FrameWork\Attribute\Column;
use PDO;
use ReflectionClass;

/**
 * @webTech2:
 *
 *  @INHOUD:
 *          Klaase: Deze klasse Mapping is een database mapper, die het mogelijk maakt om objecten van een bepaalde entity (entiteit)
 *                  in PHP te vertalen naar rijen in een relationele database, en vice versa.
 *                  Het biedt methoden voor het opslaan, bijwerken, ophalen en verwijderen van entiteiten van de database.
 *
 */

 class Mapping implements DatabaseMapperInterface {

    public function __construct(#[Argument(connectorClass: "PDO", exceptionClass: "PDOException")] private DatabaseConnection $db,
                                private array $data = [],
                                private string $table = '')
    {
        $this->table = $this->getTable();
    }


     /**
      * @param string $name
      * @param $value
      * @return void
      */
    public function setAttribute(string $name, $value)
    {
        $this->data[$name] = $value;
    }

     /**
      * @param string $name
      * @return mixed|null
      */
    public function getAttribute(string $name)
    {
        return $this->data[$name] ?? null;
    }

     /**
      * @return string
      */
     public function getTable(): string
     {
         $classParts = explode('\\', static::class);
         $className = end($classParts);
         return strtolower($className);
     }

     /**
      * @return array
      */
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

     /**
      * @return bool
      */
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

     /**
      * @param array $criteria
      * @return bool
      */
     public function update(array $criteria): bool
     {
         $data = $this->toDatabaseArray();
         $whereClauses = [];

         foreach ($criteria as $attribute => $value) {
             $whereClauses[] = "{$attribute} = ?";
         }

         $whereClause = implode(' AND ', $whereClauses);
         $sql = "UPDATE {$this->table} SET "; //($columns) VALUES ($values)";
         foreach (array_keys($data) as $column){
             $sql .= "$column = ?, ";
         }
         // remove final comma
         $sql = substr($sql, 0, -2);
         $sql .= " WHERE {$whereClause}";

         $commit = $this->db->getConnector()->prepare($sql);

         $i = 1;
         foreach ($data as $value) {
             $commit->bindValue($i++, $value);
         }

         foreach ($criteria as $value) {
             $commit->bindValue($i++, $value);
         }

         return $commit->execute();
     }


     /**
      * @param string $column
      * @return array
      */
    //geeft alle values van de gevraagde column
    public function findby(string $column): array
    {

        $table = (new static($this->db))->getTable();

        $stmt = $this->db->getConnector()->prepare("SELECT $column FROM $table");
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $instances = [];
        foreach ($data as $row) {
            $instances[] = $row[$column];
        }
        return $instances;
    }

     /**
      * @param array $criteria
      * @return $this|null
      */
    // hier kan gefilterd worden, geeft een object terug van zelfde entity type
    public function find(array $criteria): ?static
    {
        $table = (new static($this->db))->getTable();
        $whereClauses = [];

        foreach ($criteria as $attribute => $value) {
            $whereClauses[] = "{$attribute} = ?";}

        $whereClause = implode(' AND ', $whereClauses);
        $sql = "SELECT * FROM {$table} WHERE {$whereClause} LIMIT 1";
        $statement = $this->db->getConnector()->prepare($sql);

        $i = 1;
        foreach ($criteria as $value) {
            $statement->bindValue($i++, $value);}

        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return new static($this->db, $result);}
        else {
            return null;}
    }

     /**
      * @param array|null $criteria
      * @return array
      */
    //geeft een lijst terug van alle objecten van de betreffende entity
    public function findAll(array $criteria = null): array
    {

        $table = (new static($this->db))->getTable();
        if (isset($criteria)) {
            $whereClauses = [];

            foreach ($criteria as $attribute => $value) {
                $whereClauses[] = "{$attribute} = ?";
            }

            $whereClause = implode(' AND ', $whereClauses);
            $sql = "SELECT * FROM {$table} WHERE {$whereClause}";
        } else {
            $sql = "SELECT * FROM {$table}";
        }
        $statement = $this->db->getConnector()->prepare($sql);

        if (isset($criteria)) {
            $i = 1;
            foreach ($criteria as $value) {
                $statement->bindValue($i++, $value);
            }
        }

        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);

        $objects = [];
        foreach ($results as $result) {
            $objects[] = new static($this->db, $result);
        }

        return $objects;
    }

}
