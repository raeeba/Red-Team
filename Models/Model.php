<?php
include_once __DIR__ . '/../database.php';

class Model {
    protected $conn;

    public function __construct() {
     $this->conn=Database::getConnection();  
    }


    public static function getConnection() {
        return self::$conn;
    }
    

    // Check if user is in session
    public static function checkSession() {
        session_start();
        if (!isset($_SESSION['email']) || !isset($_SESSION['role']) || !isset($_SESSION['group_id'])) {
            header("Location: /user/login.php");
            exit();
        }
    }

    // Check if user has permission to perform a specific action
    public static function checkPermission($requiredAction) {
        self::checkSession(); 

        $groupId = $_SESSION['group_id'];

        $sql = "SELECT 1 FROM groupactions ga
                JOIN actions a ON ga.action_id = a.id
                WHERE ga.group_id = ? AND a.name = ?";
                
        $stmt = self::$conn->prepare($sql);
        $stmt->bind_param("is", $groupId, $requiredAction);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            echo "Access denied. You do not have permission to perform this action.";
            exit();
        }
    }
}
?>
