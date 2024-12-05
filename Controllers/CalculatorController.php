<?php

include_once __DIR__ . "/../Models/Calculator.php";
include_once __DIR__ . "/../Models/Inventory.php";
include_once __DIR__ . "/Controller.php";

class CalculatorController extends Controller
{
    function route()
    {
        $action = isset($_GET['action']) ? $_GET['action'] : "view";

        if ($action == "view") {
            $this->checkSession();

            $this->calculatorView();
        } else if ($action == "calculate" && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkSession();

            $this->calculatorCalculate();
        } else {

            $this->render("calculator", "view");
        }
    }

    private function calculatorView()
    {

        if (!$this->verifyRights($_SESSION['email'], 'calculator', 'view')) {
            echo "Permission denied.";
            return false;
        }

        $inventoryModel = new Inventory();

        $productList = $inventoryModel->listInventoryForCalculator();

        $userData = [
            'name' => $_SESSION['name'],
            'email' => $_SESSION['email']
        ];

        $data = [
            'user' => $userData,
            'products' => $productList
        ];

        if (isset($_SESSION['calculation_data'])) {

            $data = array_merge($data, $_SESSION['calculation_data']);
            unset($_SESSION['calculation_data']); // Clear session data after usage
        }
        $this->render("calculator", "view", $data);
    }

    private function calculatorCalculate()
    {
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
            $_SESSION['calculation_data'] = $data;
            $this->render("calculator", "view", $data);
        }
    }
}
