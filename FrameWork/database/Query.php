<?php
namespace FrameWork\database;
use FrameWork\database\DatabaseConnection;
use Exception;


class Query
{
    private $sqlBuilder = '';

    public static function select($columns = '*')
    {
        $query = new Query();
        $query->sqlBuilder = "SELECT $columns";
        return $query;
    }

    public function from($table)
    {
        $this->sqlBuilder .= " FROM $table";
        return $this;
    }

    public function where($condition)
    {
        $this->sqlBuilder .= " WHERE $condition";
        return $this;
    }


    public function join($table, $condition)
    {
        $this->sqlBuilder .= " JOIN $table ON $condition";
        return $this;
    }




    public static function delete()
    {
        $query = new Query();
        $query->sqlBuilder = "DELETE";
        return $query;

    }
    public function table($table)
    {
        $this->sqlBuilder .= " $table";
        return $this;
    }


    public static function insert()
    {
        $query = new Query();
        $query->sqlBuilder = "INSERT";
        return $query;

    }

    public static function update()
    {
        $query = new Query();
        $query->sqlBuilder = "UPDATE";
        return $query;

    }


    public function execute(DatabaseConnection $mysql)
    {
        $mysql = $mysql->getConnector();
        $data = $mysql->prepare($this->sqlBuilder);
        $data->execute();
        return $data->fetchAll();

    }
}
