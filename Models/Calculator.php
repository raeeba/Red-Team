<?php

$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "amolinatdb"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$length = $_POST['length'] ?? null;
$height = $_POST['height'] ?? null;
$thickness = $_POST['thickness'] ?? null;
$spacing = $_POST['spacing'] ?? null;
$load_bearing = $_POST['load_bearing'] ?? null;

if (!validateInput($length) || !validateInput($height) || !validateInput($thickness) || 
    !validateInput($spacing) || !validateInput($load_bearing)) {
    echo "Invalid input. Please ensure all fields are filled correctly.";
    exit;
}

$wool_needed = calculate_wool_needed($length, $height, $thickness, $spacing, $load_bearing);
$planks_needed = calculate_planks_needed($length, $height, $thickness, $spacing, $load_bearing);

echo "<h2>Results</h2>";
echo "Amount of Wool Needed: " . number_format($wool_needed, 2) . " cubic meters<br>";
echo "Amount of Planks Needed: " . $planks_needed . " planks<br>";

$conn->close();

function validateInput($input) {
    return is_numeric($input) && $input > 0;
}

function calculate_wool_needed($length, $height, $thickness, $spacing, $load_bearing) {
    $area = $length * $height;
    $volume_needed = $area * $thickness;
    return $volume_needed * (1 + $spacing / 100);
}

function calculate_planks_needed($length, $height, $thickness, $spacing, $load_bearing) {
    $area = $length * $height;
    $plank_width = 0.1; // Adjust as needed
    $plank_area = $plank_width * $thickness;
    $num_planks = ceil($area / $plank_area);
    return ceil($num_planks * (1 + $spacing / 100));
}
?>