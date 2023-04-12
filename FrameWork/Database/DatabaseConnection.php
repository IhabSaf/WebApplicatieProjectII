<?php
namespace FrameWork\database;
use Exception;
use PDO;
use PDOException;

class DatabaseConnection {
    private string $host = "localhost";
    private string $username = "Ihab";
    private string $password = "Welkom01!";
    private string $dbname = "web2project";
    private PDO $connector;

    /**
     * @throws Exception
     */
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

    public function getConnector(): PDO
    {
        return $this->connector;
    }

    public function close(): void
    {
        $this->connector = null;
    }
}
