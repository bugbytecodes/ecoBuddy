<?php
require_once __DIR__ . '/../Models/EcoFacility.php';

class EcoFacilityController
{
    private EcoFacility $facilityModel;
    private stdClass $view;
    private int $itemsPerPage = 10;

    public function __construct(EcoFacility $facilityModel, stdClass $view) {
        $this->facilityModel = $facilityModel;
        $this->view = $view;
        $this->view->siteName = 'EcoBuddy';
    }

    // EcoFacilityController.php
    public function searchAction(): void
    {
        error_log("SEARCH ACTION CALLED! Query: " . ($_GET['query'] ?? 'NULL'));

        // Ensure view exists
        if (!isset($this->view)) {
            $this->view = new stdClass();
            error_log("Created new view object in searchAction");
        }

        // Set view properties
        $this->view->searchTerm = $_GET['query'] ?? '';
        $this->view->facilities = !empty($this->view->searchTerm)
            ? $this->facilityModel->search($this->view->searchTerm)
            : [];

        // Make view available to template
        $view = $this->view; // Critical - makes $view available in template scope

        // Debug before requiring template
        error_log("View contents before render: " . print_r($this->view, true));

        // Directly include the template
        require __DIR__ . '/../Views/index.phtml';
    }


    public function viewAction(int $id): void {
        try {
            $this->view->facility = $this->facilityModel->getById($id);

            if (!$this->view->facility) {
                throw new Exception("Facility not found");
            }

            $this->view->pageTitle = $this->view->facility['title'] ?? 'Facility Details';
            require __DIR__ . '/../Views/eco-facility/view.phtml';

        } catch (Exception $e) {
            $this->view->error = $e->getMessage();
            require __DIR__ . '/../Views/error.phtml';
        }
    }


    public function listAction(): void
    {
        // Get all facilities from model
        $facilities = $this->facilityModel->getAllFacilities(); // Make sure this method exists

        // Assign to view
        $this->view->facilities = $facilities ?? []; // Ensure it's always an array

        // Set page title
        $this->view->pageTitle = 'All Eco Facilities';

        // Load view
        require __DIR__ . '/../Views/index.phtml';
    }


}