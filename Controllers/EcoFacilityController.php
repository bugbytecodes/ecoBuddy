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

    public function searchAction(): void
    {
        // Create view object if it doesn't exist
        if (!isset($this->view)) {
            $this->view = new stdClass();
        }

        // Set search term
        $this->view->searchTerm = $_GET['query'] ?? '';

        // Perform search
        $this->view->facilities = $this->facilityModel->search($this->view->searchTerm);

        // Render the view
        $this->render('eco-facility/list.phtml');
    }

    private function render(string $template): void
    {
        // Make view properties available to template
        $view = $this->view;
        require __DIR__ . '/../Views/' . $template;
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
        require __DIR__ . '/../Views/eco-facility/list.phtml';
    }


}