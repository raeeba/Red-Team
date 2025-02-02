<?php
include_once __DIR__ . '/../database.php';

class Controller {
    protected $conn;
    protected $basePath;

    public function __construct() {
        $this->conn = Database::getConnection();
    }
    //get the path of the file
    protected function getBasePath() {
        if ($this->basePath === null) {
            //get the directory path of the currently executed script relative to the root
            //localhost/Red-Team/user/login --> /user/login (dirname makes it /folder)
            $this->basePath = dirname($_SERVER['SCRIPT_NAME']);
            //make sure theirs no trailing slashes
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

    //check whether the user has a session(if not, redirect to login)
    protected function checkSession() {

        if (!isset($_SESSION['email'])) {
            
            $basePath = $this->getBasePath();

            echo "<pre>Debug: Redirecting to " . $basePath . "/en/user/login</pre>";
            header("Location: " . $basePath. "/" . $_SESSION['language']. "/user/login");
            exit();

        }
    }

    //returns a true or false. used in the login screen to redirect the user to inventory (the opposite of checkSession)
    public function isLoggedIn() {
        return isset($_SESSION['email']);
    }
    
    //verifies the rights of the user
    //check whether the email of the user is associated with the right for an action (modify employee, ect)
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
            //returns true if the email is associated with an action
            return $userCount > 0;
        }
        return false;
    }
}

?>
