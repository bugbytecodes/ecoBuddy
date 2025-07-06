<?php
// Models/Database.php
class Database
{
    private ?PDO $connection = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $dbPath = __DIR__ . '/../data/ecobuddy.sqlite';

        if (!file_exists($dbPath)) {
            throw new Exception("Database file not found at: $dbPath");
        }

        $this->connection = new PDO(
            'sqlite:' . $dbPath,
            null,
            null,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }

    public function getConnection(): PDO
    {
        if ($this->connection === null) {
            throw new Exception("Database connection not initialized");
        }
        return $this->connection;
    }
}