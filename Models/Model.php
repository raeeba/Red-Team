<?php
include_once __DIR__ . '/../database.php';

class Model {
    protected $conn;
    protected $basePath; 

    public function __construct() {
     $this->conn=Database::getConnection();  
    }


    public static function getConnection() {
        return self::$conn;
    }

    //transaction for insert product
    public function beginTransaction() {
        $this->conn->begin_transaction();
    }

    public function commit() {
        $this->conn->commit();
    }

    public function rollBack() {
        $this->conn->rollBack();
    }

    public function getBasePath() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];  
        $basePath = $protocol . "://" . $host;  
        return $basePath;
    }

}
?>
