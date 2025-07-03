<?php
$view = new stdClass();
$view->pageTitle = 'Homepage';

// Only include template files
  // This should use $view-> variables

require_once 'models/Database.php';
require_once 'models/EcoFacility.php';
require_once 'models/User.php';

$controller = new EcoFacilityController();

$action = $_GET['action'] ?? 'list';

switch ($action) {
    case 'list':
        $controller->listAction();
        break;
    case 'search':
        $controller->searchAction();
        break;
    case 'view':
        $id = $_GET['id'] ?? 0;
        $controller->viewAction($id);
        break;
    default:
        $controller->listAction();
}
