<?php

namespace FrameWork\database;

use Exception;

class DatabaseConnection {
    private string $host = "localhost";
    private string $username = "Ihab";
    private string $password = "Welkom01!";
    private string $dbname = "web2project";
    private object $connector;

    /**
     * @throws Exception
     */
    public function __construct(private string $connectorClass = "PDO",
                                private string $exceptionClass = "PDOException")
    {
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
        $options = array($this->connectorClass::ATTR_ERRMODE => $this->connectorClass::ERRMODE_EXCEPTION, $this->connectorClass::ATTR_DEFAULT_FETCH_MODE => $this->connectorClass::FETCH_ASSOC);

        try {
            $this->connector = new $this->connectorClass($dsn, $this->username, $this->password, $options);
        } catch (Exception $e) {
            echo match (get_class($e)) {
                $this->exceptionClass => throw new $this->exceptionClass("contact met database is niet gelukt: " . $e->getMessage()),
                default => throw new Exception("contact met database is niet gelukt: " . $e->getMessage()),
            };
        }
    }

    public function getConnector(): object
    {
        return $this->connector;
    }

    public function close(): void
    {
        $this->connector = null;
    }
}
