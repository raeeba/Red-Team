<?php
class Database {
    private static $instance = null;
    private $conn;

    private function __construct() {
        $host = 'localhost'; // Update this if needed
        $user = 'root'; // Update this if needed
        $password = ''; // Update this if needed
        $database = 'amolinatdb'; // Update this if needed

        // Establish a new database connection
        $this->conn = new mysqli($host, $user, $password, $database);

        // Check if the connection was successful
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getConnection() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->conn;
    }
}
?>
