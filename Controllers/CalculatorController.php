<?php

// Including necessary files for models and controllers
include_once __DIR__ . "/../Models/Calculator.php";  // Calculator model for calculations
include_once __DIR__ . "/../Models/Inventory.php";   // Inventory model for product data
include_once __DIR__ . "/Controller.php";            // Base controller class

// CalculatorController class extending the base Controller
class CalculatorController extends Controller
{
    // Route function to handle different actions (view or calculate)
    function route()
    {
        // Check for the action parameter in the GET request, default to 'view' if not present
        $action = isset($_GET['action']) ? $_GET['action'] : "view";

        // If the action is 'view', render the calculator view
        if ($action == "view") {
            $this->checkSession();  // Ensure the user is logged in/session exists

            $this->calculatorView();  // Render the view for calculator
        } 
        // If the action is 'calculate' and the request method is POST, perform the calculation
        else if ($action == "calculate" && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkSession();  // Ensure the user is logged in/session exists

            $this->calculatorCalculate();  // Perform calculation
        } 
        // If no valid action, render the calculator view
        else {
            $this->render("calculator", "view");  // Default render
        }
    }

    // Function to render the calculator view with necessary data
    private function calculatorView()
    {
        // Check user permissions to view the calculator
        if (!$this->verifyRights($_SESSION['email'], 'calculator', 'view')) {
            echo "Permission denied.";  // If no permission, deny access
            return false;
        }

        // Create an instance of Inventory model to get product data
        $inventoryModel = new Inventory();

        // Fetch a list of products available for the calculator
        $productList = $inventoryModel->listInventoryForCalculator();

        // Get user data from session (name and email)
        $userData = [
            'name' => $_SESSION['name'],
            'email' => $_SESSION['email']
        ];

        // Prepare data to pass to the view (user data and product list)
        $data = [
            'user' => $userData,
            'products' => $productList
        ];

        // If there's any previous calculation data in the session, merge it with the view data
        if (isset($_SESSION['calculation_data'])) {
            $data = array_merge($data, $_SESSION['calculation_data']);
            unset($_SESSION['calculation_data']);  // Clear session data after usage
        }

        // Render the view with the data (calculator page)
        $this->render("calculator", "view", $data);
    }

    // Function to handle the calculation logic
    private function calculatorCalculate()
    {
        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Check user permissions to perform calculation
            if (!$this->verifyRights($_SESSION['email'], 'calculator', 'calculate')) {
                echo "Permission denied.";  // If no permission, deny access
                return false;
            }

            // Log the POST data for debugging purposes
            error_log('Calculator calculate called with POST data: ' . print_r($_POST, true));

            // Extract input values from the POST request, trim and set defaults
            $length = isset($_POST['length']) ? trim($_POST['length']) : null;
            $height = isset($_POST['height']) ? trim($_POST['height']) : null;
            $thickness = isset($_POST['thickness']) ? trim($_POST['thickness']) : null;
            $spacing = isset($_POST['spacing']) ? trim($_POST['spacing']) : null;
            $loadBearing = isset($_POST['load_bearing']) ? trim($_POST['load_bearing']) : null;

            // Initialize variables for error and results
            $error = null;
            $results = null;

            // Check if all inputs are numeric, if so, perform the calculation
            if (is_numeric($length) && is_numeric($height) && is_numeric($thickness) && is_numeric($spacing) && is_numeric($loadBearing)) {
                // Create an instance of CalculatorModel to perform calculations
                $calculatorModel = new CalculatorModel();
                // Call the calculate function and store the results
                $results = $calculatorModel->calculate($length, $height, $thickness, $spacing, $loadBearing);
            } else {
                // If inputs are not numeric, set an error message
                $error = "All fields must be numeric values.";
            }

            // Log the calculation results for debugging purposes
            error_log('Results after calculation: ' . print_r($results, true));

            // Prepare the data to pass back to the view (calculation inputs, error message, and results)
            $data = [
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'length' => $length,
                'height' => $height,
                'thickness' => $thickness,
                'spacing' => $spacing,
                'load_bearing' => $loadBearing,
                'error' => $error,
                'results' => $results
            ];

            // Store the calculation data in session for persistence (e.g., for showing after page reload)
            $_SESSION['calculation_data'] = $data;

            // Render the calculator view with the results data
            $this->render("calculator", "view", $data);
        }
    }
}
