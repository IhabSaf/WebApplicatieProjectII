<?php
namespace FrameWork\database;

class Query
{
    private string $sqlBuilder = '';

    public static function select(string $columns = '*'): Query
    {
        $query = new Query();
        $query->sqlBuilder = "SELECT $columns";
        return $query;
    }

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


    public static function insert(): Query
    {
        $query = new Query();
        $query->sqlBuilder = "INSERT";
        return $query;

    }

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
}
