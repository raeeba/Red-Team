<?php

class Model {
    protected $conn;

    public function __construct() {
        // Database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "amolinatdb";

        // Create a new connection
        $this->conn = new mysqli($servername, $username, $password, $database);

        // Check the connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Destructor to close the database connection when the model is destroyed
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
