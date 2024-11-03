<?php
require_once __DIR__ . '/../Models/Model.php';

class CalculatorModel extends Model {
    public function calculate($length, $height, $thickness, $spacing, $loadBearing) {
        // Perform calculations
        $woolNeeded = $length * $height * $thickness; 
        $planksNeeded = ($length / $spacing) * $loadBearing; 
    
        return [
            'wool_needed' => $woolNeeded,
            'planks_needed' => $planksNeeded
        ];
    }
}
?>