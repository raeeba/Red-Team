<?php
/*error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include paths as before
$pathToCalculator = __DIR__ . "/../Models/Calculator.php";
$pathToController = __DIR__ . "/Controller.php";

if (file_exists($pathToCalculator) && file_exists($pathToController)) {
    include_once $pathToCalculator;
    include_once $pathToController;
} else {
    echo "One or more files not found:";
    var_dump(file_exists($pathToCalculator), file_exists($pathToController));
    exit;
}*/

class CalculatorController extends Controller {

    public function route() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
            $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
            $thickness = filter_input(INPUT_POST, 'thickness', FILTER_VALIDATE_FLOAT);
            $spacing = filter_input(INPUT_POST, 'spacing', FILTER_VALIDATE_FLOAT);
            $load_bearing = filter_input(INPUT_POST, 'load_bearing', FILTER_VALIDATE_FLOAT);

            $calculator = new Calculator($length, $height, $thickness, $spacing, $load_bearing);

            if (!$calculator->validateInput()) {
                $errorMessage = "Invalid input. All values must be positive.";
                return $this->render('Calculator', ['error' => $errorMessage, 'results' => null]);
            }

            $wool_needed = $calculator->calculateWoolNeeded();
            $planks_needed = $calculator->calculatePlanksNeeded();

            $results = [
                'wool_needed' => number_format($wool_needed, 2),
                'planks_needed' => $planks_needed,
            ];

            return $this->render('Calculator', ['results' => $results]);
        } else {
            return $this->render('Calculator', ['results' => null]);
        }
    }
}


?>