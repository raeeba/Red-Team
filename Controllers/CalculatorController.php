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
    private function calculatorView() {
        if (!$this->verifyRights($_SESSION['email'], 'calculator', 'view')) {
            echo "Permission denied.";
            return false;
        }
    
        $inventoryModel = new Inventory();
        $productList = $inventoryModel->listInventoryForCalculator() ?: []; // Ensure it's an array
    
        $userData = [
            'name' => $_SESSION['name'],
            'email' => $_SESSION['email']
        ];
    
        $data = [
            'user' => $userData,
            'products' => $productList
        ];
    
        if (isset($_SESSION['calculation_data'])) {
            $_SESSION['calculation_data']['products'] = $productList; // Preserve products
            $data = array_merge($data, $_SESSION['calculation_data']);
            unset($_SESSION['calculation_data']);
        }
    
        $this->render("calculator", "view", $data);
    }
    
    // Function to handle the calculation logic
    private function calculatorCalculate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (!$this->verifyRights($_SESSION['email'], 'calculator', 'calculate')) {
                echo "Permission denied.";
                return false;
            }
    
            error_log('Calculator calculate called with POST data: ' . print_r($_POST, true));
    
            $length = isset($_POST['length']) ? trim($_POST['length']) : null;
            $height = isset($_POST['height']) ? trim($_POST['height']) : null;
            $thickness = isset($_POST['thickness']) ? trim($_POST['thickness']) : null;
            $spacing = isset($_POST['spacing']) ? trim($_POST['spacing']) : null;
            $loadBearing = isset($_POST['load_bearing']) ? trim($_POST['load_bearing']) : null;
    
            $error = null;
            $results = null;
    
            if (is_numeric($length) && is_numeric($height) && is_numeric($thickness) && is_numeric($spacing) && is_numeric($loadBearing)) {
                $calculatorModel = new CalculatorModel();
                $results = $calculatorModel->calculate($length, $height, $thickness, $spacing, $loadBearing);
            } else {
                $error = "All fields must be numeric values.";
            }
    
            error_log('Results after calculation: ' . print_r($results, true));
    
            $inventoryModel = new Inventory(); // Re-fetch products
            $data = [
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'length' => $length,
                'height' => $height,
                'thickness' => $thickness,
                'spacing' => $spacing,
                'load_bearing' => $loadBearing,
                'error' => $error,
                'results' => $results,
                'products' => $inventoryModel->listInventoryForCalculator() ?: [] // Always include products
            ];
    
            $_SESSION['calculation_data'] = $data;
            $this->render("calculator", "view", $data);
        }
    }
    
}
