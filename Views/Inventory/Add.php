<?php
// Database connection
$servername = "localhost"; // Change if needed
$username = "root"; // Change if needed
$password = ""; // Change if needed
$dbname = "inventory"; // Change to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['name'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Prepare and bind
    $ct = $conn->prepare("INSERT INTO products (name, description, quantity, price) VALUES (?, ?, ?, ?)");
    $ct->bind_param("ssids", $name, $description, $quantity, $price);

    // Execute the statement
    if ($ct->execute()) {
        echo "New product added successfully!";
    } else {
        echo "Error: " . $action->error;
    }

    // Close the statement
    $conn->close();
}

// Close the connection
$conn->close();

?>