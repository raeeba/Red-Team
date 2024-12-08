<?php
require_once __DIR__ . '/../Models/Model.php';

class CalculatorModel extends Model {
    public function calculate($length, $height, $thickness, $spacing, $loadBearing) {
        // Perform calculations
        $woolNeeded = $length * $height * ($thickness/12); 
        
        $horizontalPlanks = $loadBearing; 
        $verticalPlanks = ceil($length / ($spacing / 12)); 
        
        $planksNeeded = $verticalPlanks + $horizontalPlanks;
    
        return [
            'wool_needed' => $woolNeeded,
            'planks_needed' => $planksNeeded
        ];
    }
}
?>