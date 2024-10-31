<?php

class CalculatorController extends Controller {
    const PLANK_WIDTH = 0.1; 

    public function calculate() {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $length = filter_input(INPUT_POST, 'length', FILTER_VALIDATE_FLOAT);
            $height = filter_input(INPUT_POST, 'height', FILTER_VALIDATE_FLOAT);
            $thickness = filter_input(INPUT_POST, 'thickness', FILTER_VALIDATE_FLOAT);
            $spacing = filter_input(INPUT_POST, 'spacing', FILTER_VALIDATE_FLOAT);
            $load_bearing = filter_input(INPUT_POST, 'load_bearing', FILTER_VALIDATE_FLOAT);

            if (!$this->isValidInput($length, $height, $thickness, $spacing, $load_bearing)) {
                $errorMessage = "Invalid input. All values must be positive.";
                return $this->render('wool_calculator', ['error' => $errorMessage]);
            }

            $wool_needed = $this->calculate_wool_needed($length, $height, $thickness, $spacing);
            $planks_needed = $this->calculate_planks_needed($length, $height, $thickness, $spacing);

            $this->render('results', [
                'wool_needed' => number_format($wool_needed, 2),
                'planks_needed' => $planks_needed,
            ]);
        } else {
            $this->render('wool_calculator');
        }
    }

    private function isValidInput($length, $height, $thickness, $spacing, $load_bearing) {
        return $length > 0 && $height > 0 && $thickness > 0 && $spacing >= 0 && $load_bearing > 0;
    }

    private function calculate_wool_needed(float $length, float $height, float $thickness, float $spacing): float {
        $area = $length * $height;
        $volume_needed = $area * $thickness;
        return $volume_needed * (1 + $spacing / 100);
    }

    private function calculate_planks_needed(float $length, float $height, float $thickness, float $spacing): int {
        $area = $length * $height;
        $plank_area = self::PLANK_WIDTH * $thickness;
        $num_planks = ceil($area / $plank_area);
        return ceil($num_planks * (1 + $spacing / 100));
    }
}