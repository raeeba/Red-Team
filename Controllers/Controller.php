<?php
include_once __DIR__ . '/../database.php';

class Controller {
    protected $conn;

    protected $basePath;

    public function __construct() {
        $this->conn = Database::getConnection();
    }
    protected function getBasePath() {
        if ($this->basePath === null) {
            $this->basePath = dirname($_SERVER['SCRIPT_NAME']);
            $this->basePath = rtrim($this->basePath, '/\\');
        }
        return $this->basePath;
    }

    function route() {
    }

    function render($controller, $view, $data = []) {
        extract($data);  
        include "Views/$controller/$view.php";
    }

    protected function checkSession() {
   //     session_start();
        if (!isset($_SESSION['email'])) {
            $basePath = $this->getBasePath();
            echo "<pre>Debug: Redirecting to " . $basePath . "/en/user/login</pre>";
            header("Location: " . $basePath . "/en/user/login");
            exit();
        }
    }

    public function isLoggedIn() {
   //     session_start();
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
