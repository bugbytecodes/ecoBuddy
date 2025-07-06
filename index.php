<?php
// Initialize view
$view = new stdClass();
$view->pageTitle = 'EcoFacilities';

// Load dependencies
require_once 'models/Database.php';
require_once 'models/EcoFacility.php';
require_once 'models/User.php';
require_once 'controllers/EcoFacilityController.php';

try {
    // Database connection with error handling
    $database = new Database();
    $pdo = $database->getConnection();

    // Initialize MVC components
    $facilityModel = new EcoFacility($pdo);
    $controller = new EcoFacilityController($facilityModel, $view);

    // Route requests
    $action = $_GET['action'] ?? 'list';
    $id = (int)($_GET['id'] ?? 0);

    switch ($action) {
        case 'list':
            $controller->listAction();
            break;
        case 'search':
            $controller->searchAction();
            break;
        case 'view':
            $controller->viewAction($id);
            break;
        default:
            $controller->listAction();
    }

} catch (PDOException $e) {
    // Database connection errors
    die("Database error: " . $e->getMessage());
} catch (Exception $e) {
    // General errors (like missing database file)
    die("Application error: " . $e->getMessage());
}