<?php
namespace FrameWork\database;

class Query
{
    private string $sqlBuilder = '';

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

    public function insert(Mapping $mapping): void
    {
        $table = $mapping->getTableName();
        $columns = implode(',', array_keys($mapping->toDatabaseArray()));
        $values = implode(',', array_fill(0, count($mapping->toDatabaseArray()), '?'));

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute($mapping->getBindValues());
    }

    public function select(Mapping $mapping, string $where = ''): array
    {
        $table = $mapping->getTableName();
        $columns = implode(',', array_keys($mapping->toDatabaseArray()));

        $sql = "SELECT $columns FROM $table $where";
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new $mapping($row);
        }

        return $results;
    }
}
