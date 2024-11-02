class CalculatorController extends Controller {

    public function calculate() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
            $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
            $thickness = filter_input(INPUT_POST, 'thickness', FILTER_VALIDATE_FLOAT);
            $spacing = filter_input(INPUT_POST, 'spacing', FILTER_VALIDATE_FLOAT);
            $load_bearing = filter_input(INPUT_POST, 'load_bearing', FILTER_VALIDATE_FLOAT);

            $calculator = new Calculator($length, $height, $thickness, $spacing, $load_bearing);

            if (!$calculator->validateInput()) {
                $errorMessage = "Invalid input. All values must be positive.";
                return $this->render('Calculator', ['error' => $errorMessage]); // Adjusted to use Calculator.php
            }

            $wool_needed = $calculator->calculateWoolNeeded();
            $planks_needed = $calculator->calculatePlanksNeeded();

            // Return the results to the same view
            return $this->render('Calculator', [
                'results' => [
                    'wool_needed' => number_format($wool_needed, 2),
                    'planks_needed' => $planks_needed,
                ],
            ]);
        } else {
            return $this->render('Calculator'); // Render the form initially
        }
    }
}
