

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

    public function search(string $term): array
    {
        $stmt = $this->db->prepare("SELECT * FROM ecoFacilities 
                               WHERE title LIKE ? 
                               OR description LIKE ?");
        $stmt->execute(["%$term%", "%$term%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }
    public function getById(int $id): array|false
    {
        $stmt = $this->db->prepare("SELECT * FROM ecoFacilities WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
