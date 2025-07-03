<?php
// Models/Database.php
class Database {
    private static ?Database $instance = null;
    private PDO $connection;

    /**
     * @throws Exception
     */
    private function __construct() {
        try {
            $this->connection = new PDO(
                'sqlite:' . __DIR__ . '/../data/ecobuddy.db',
                null,
                null,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection(): PDO {
        return $this->connection;
    }
}