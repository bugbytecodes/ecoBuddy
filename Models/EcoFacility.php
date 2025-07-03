//functions go here

<?php
// Models/EcoFacility.php
require_once __DIR__ . '/Database.php';

class EcoFacility {
    private PDO $db;

    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }

    public function search(string $term): array {
        $stmt = $this->db->prepare("SELECT * FROM ecoFacilities WHERE title LIKE ?");
        $stmt->execute(["%$term%"]);
        return $stmt->fetchAll();
    }

    public function getAllFacilities(): array {
        $stmt = $this->db->prepare("SELECT * FROM ecoFacilities");
        $stmt->execute();
        return $stmt->fetchAll();
    }
}