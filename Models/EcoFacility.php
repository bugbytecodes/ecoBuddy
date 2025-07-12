

<?php
// Models/EcoFacility.php
require_once __DIR__ . '/Database.php';

class EcoFacility
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

// models/EcoFacility.php
    public function search(string $term): array
    {
        $stmt = $this->db->prepare("SELECT * FROM ecoFacilities 
                           WHERE title LIKE ? 
                           OR category LIKE ?
                           OR streetname LIKE ?
                           OR postcode LIKE ?");
        $searchTerm = "%$term%";
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function getAllFacilities(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM ecoFacilities");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
        } catch (PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }
}
