<?php
include_once __DIR__ . '/../database.php';

class Controller {
    protected $conn;

    // Define the basePath property
    protected $basePath;

    public function __construct() {
        $this->conn = Database::getConnection();
    }
    // Method to initialize and return basePath
    protected function getBasePath() {
        if ($this->basePath === null) {
            // Initialize basePath here only if it has not been initialized yet
            $this->basePath = dirname($_SERVER['SCRIPT_NAME']);
            // Remove trailing slash if present to avoid double slashes
            $this->basePath = rtrim($this->basePath, '/\\');
        }
        return $this->basePath;
    }

    // Route function (to be overridden by subclasses)
    function route() {
        // Placeholder for route implementation in child controllers
    }

    // Render function for including views
    function render($controller, $view, $data = []) {
        extract($data);  // Extracts array elements as variables
        include "Views/$controller/$view.php";
    }

    // Session validation method
    protected function checkSession() {
        session_start();
        if (!isset($_SESSION['email'])) {
            // Debugging output to see if redirection code is reached
            $basePath = $this->getBasePath();
            echo "<pre>Debug: Redirecting to " . $basePath . "/en/user/login</pre>";
            // Redirection to login page
            header("Location: " . $basePath . "/en/user/login");
            exit();
        }
    }

    // Helper function to check if the user is logged in
    public function isLoggedIn() {
        session_start();
        return isset($_SESSION['email']);
    }
    protected function verifyRights($email, $controller = 'user', $action = 'list') {
        $sql = "SELECT COUNT(userlogin.email) AS user_count
                FROM userlogin
                INNER JOIN usergroup ON userlogin.email = usergroup.email
                INNER JOIN groupactions ON usergroup.group_id = groupactions.group_id
                INNER JOIN rights ON groupactions.action_id = rights.id
                WHERE userlogin.email = ?
                AND rights.action LIKE ?
                AND rights.controller LIKE ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sss", $email, $action, $controller);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userCount);
            $stmt->fetch();
            return $userCount > 0;
        }
        return false;
    }
}

?>
