<?php

include_once __DIR__ . "/../Models/Calculator.php";
include_once __DIR__ . "/Controller.php";

class CalculatorController extends Controller {
    function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "view";

        if ($action == "view") {
            $this->calculatorView();
        } else if ($action == "calculate" && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->calculatorCalculate();
        } else {
            echo "Invalid action.";
        }
    }

    private function calculatorView() {
        session_start();

        if (!$this->verifyRights($_SESSION['email'], 'calculator', 'view')) {
            echo "Permission denied.";
            return false;
        }

        
        $data = [
            'name' => $_SESSION['name'],
            'email' => $_SESSION['email'],
        ];
        $this->render("calculator", "view", $data);
    }

    private function calculatorCalculate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             session_start();

        if (!$this->verifyRights($_SESSION['email'], 'calculator', 'view')) {
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
            $this->render("calculator", "view", $data);
        }
    }
}
?>
