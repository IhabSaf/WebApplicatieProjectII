<?php
namespace FrameWork\database;

use InvalidArgumentException;
use PDO;
use RuntimeException;

class Query extends Mapping
{
    private static string $sqlBuilder = '';

//    public static function select(string $columns = '*'): Query
//    {
//        $query = new Query();
//        $query->sqlBuilder = "SELECT $columns";
//        return $query;
//    }

    public function from(string $table): Query
    {
        $this->sqlBuilder .= " FROM $table";
        return $this;
    }

    public function where(string $condition): Query
    {
        $this->sqlBuilder .= " WHERE $condition";
        return $this;
    }


    public function join(string $table, string $condition): Query
    {
        $this->sqlBuilder .= " JOIN $table ON $condition";
        return $this;
    }

    public static function delete(): Query
    {
        $query = new Query();
        $query->sqlBuilder = "DELETE";
        return $query;

    }
    public function table(string $table): Query
    {
        $this->sqlBuilder .= " $table";
        return $this;
    }


//    public static function insert(): Query
//    {
//        $query = new Query();
//        $query->sqlBuilder = "INSERT";
//        return $query;
//
//    }

    public static function update(): Query
    {
        $query = new Query();
        $query->sqlBuilder = "UPDATE";
        return $query;

    }


    public function execute(DatabaseConnection $mysql): false|array
    {
        $mysql = $mysql->getConnector();
        $data = $mysql->prepare($this->sqlBuilder);
        $data->execute();
        return $data->fetchAll();

    }

//    public function insert(Mapping $mapping): void
//    {
//        $table = $mapping->getTableName();
//        $columns = implode(',', array_keys($mapping->toDatabaseArray()));
//        $values = implode(',', array_fill(0, count($mapping->toDatabaseArray()), '?'));
//
//        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
//        $stmt = $this->pdo->prepare($sql);
//
//        $stmt->execute($mapping->getBindValues());
//    }
    public static function find(array $conditions): ?self
    {
        $db = new DatabaseConnection();
        $table = (new static())->getTable();

        $where = [];
        $values = [];
        foreach ($conditions as $column => $value) {
            $where[] = "$column = ?";
            $values[] = $value;
        }

        $whereClause = implode(' AND ', $where);
        $stmt = $db->getConnector()->prepare("SELECT * FROM $table WHERE $whereClause LIMIT 1");
        $stmt->execute($values);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        $instance = new static();
        foreach ($data as $name => $value) {
            $instance->setAttribute($name, $value);
        }

        return $instance;
    }


}
