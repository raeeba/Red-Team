class Calculator {
    const PLANK_WIDTH = 0.1; // Width of the plank

    private $length;
    private $height;
    private $thickness;
    private $spacing;
    private $load_bearing;

    public function __construct($length, $height, $thickness, $spacing, $load_bearing) {
        $this->length = $length;
        $this->height = $height;
        $this->thickness = $thickness;
        $this->spacing = $spacing;
        $this->load_bearing = $load_bearing;
    }

    public function validateInput() {
        return $this->isPositiveNumber($this->length) &&
               $this->isPositiveNumber($this->height) &&
               $this->isPositiveNumber($this->thickness) &&
               $this->isNonNegativeNumber($this->spacing) &&
               $this->isPositiveNumber($this->load_bearing);
    }

    private function isPositiveNumber($input) {
        return is_numeric($input) && $input > 0;
    }

    private function isNonNegativeNumber($input) {
        return is_numeric($input) && $input >= 0;
    }

    public function calculateWoolNeeded(): float {
        $area = $this->length * $this->height;
        $volume_needed = $area * $this->thickness;
        return $volume_needed * (1 + $this->spacing / 100);
    }

    public function calculatePlanksNeeded(): int {
        $area = $this->length * $this->height;
        $plank_area = self::PLANK_WIDTH * $this->thickness;
        $num_planks = ceil($area / $plank_area);
        return ceil($num_planks * (1 + $this->spacing / 100));
    }
}
