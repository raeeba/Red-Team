class CalculatorController extends Controller {
    public function calculate() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // Capture and validate input values
            $length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
            $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
            $thickness = filter_input(INPUT_POST, 'thickness', FILTER_VALIDATE_FLOAT);
            $spacing = filter_input(INPUT_POST, 'spacing', FILTER_VALIDATE_FLOAT);
            $load_bearing = filter_input(INPUT_POST, 'load_bearing', FILTER_VALIDATE_FLOAT);

            // Debugging output
            error_log("Length: $length, Height: $height, Thickness: $thickness, Spacing: $spacing, Load Bearing: $load_bearing");

            $calculator = new Calculator($length, $height, $thickness, $spacing, $load_bearing);

            if (!$calculator->validateInput()) {
                $errorMessage = "Invalid input. All values must be positive.";
                return $this->render('Calculator', ['error' => $errorMessage, 'length' => $length, 'height' => $height, 'thickness' => $thickness, 'spacing' => $spacing, 'load_bearing' => $load_bearing]);
            }

            $wool_needed = $calculator->calculateWoolNeeded();
            $planks_needed = $calculator->calculatePlanksNeeded();

            return $this->render('Calculator', [
                'results' => [
                    'wool_needed' => number_format($wool_needed, 2),
                    'planks_needed' => $planks_needed,
                ],
                'length' => $length,
                'height' => $height,
                'thickness' => $thickness,
                'spacing' => $spacing,
                'load_bearing' => $load_bearing,
            ]);
        } else {
            return $this->render('Calculator');
        }
    }
}
