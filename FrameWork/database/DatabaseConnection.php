<?php
namespace FrameWork\database;
use Exception;
use PDO;

class DatabaseConnection {
    private $host = "localhost";
    private $username = "Ihab";
    private $password = "Welkom01!";
    private $dbname = "ihab";
    private $connector;

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);

        try {
            $this->connector = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            throw new Exception("contact met database is niet gelukt: " . $e->getMessage());
        }
    }

    public function getConnector()
    {
        return $this->connector;
    }

    public function colse() {
        $this->connector = null;
    }
}
