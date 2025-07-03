<?php
// Controllers/EcoFacilityController.php
require_once __DIR__ . '/../Models/EcoFacility.php';

class EcoFacilityController {
private EcoFacility $facilityModel;

public function __construct() {
$this->facilityModel = new EcoFacility();
}

public function searchAction(string $term): void {
$results = $this->facilityModel->search($term);
// Pass to view
}

public function listAction(): void {
$facilities = $this->facilityModel->getAllFacilities();
// Pass to view
}
}