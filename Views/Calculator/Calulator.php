<?php
// Database connection information
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "amolinatdb.";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get user input from form
$length = $_POST["length"];
$height = $_POST["height"];
$thickness = $_POST["thickness"];
$spacing = $_POST["spacing"];
$load_bearing = $_POST["load_bearing"];

// Calculate the amount of wool needed
$wool_needed = calculate_wool_needed($length, $height, $thickness, $spacing, $load_bearing);

// Calculate the amount of planks needed
$planks_needed = calculate_planks_needed($length, $height, $thickness, $spacing, $load_bearing);

// Display results
echo "<h2>Results</h2>";
echo "Amount of Wool Needed: " . $wool_needed . "<br>";
echo "Amount of Planks Needed: " . $planks_needed;

// Close database connection
$conn->close();

// Function to calculate the amount of wool needed
function calculate_wool_needed($length, $height, $thickness, $spacing, $load_bearing) {
    // Calculate the area to be insulated
    $area = $length * $height;

    // Calculate the volume of wool needed
    // Wool is typically sold by volume, so we need to consider the thickness
    $volume_needed = $area * $thickness;

    // Assuming wool is packed with some spacing, we can adjust the volume accordingly
    // This is a simple approximation and may need adjustments based on actual packing
    $effective_volume = $volume_needed * (1 + $spacing / 100);

    // Return the calculated volume needed
    return $effective_volume; // in cubic meters or appropriate unit
}

// Function to calculate the amount of planks neededfunction calculate_planks_needed($length, $height, $thickness, $spacing, $load_bearing) {
    // Calculate the area to be covered by planks
    $area = $length * $height;

    // Calculate the area of a single plank
    // Assuming planks are of standard width and thickness, you can adjust these values
    $plank_width = 0.1; // Example width of a plank in meters
    $plank_area = $plank_width * $thickness;

    // Calculate the number of planks needed
    $num_planks = ceil($area / $plank_area);

    // If spacing between planks is considered, adjust the number accordingly
    // This is a simple approximation and may need adjustments based on actual construction
    $adjusted_num_planks = ceil($num_planks * (1 + $spacing / 100));

    // Return the calculated number of planks needed
    return $adjusted_num_planks; // Number of planks needed
}
?>