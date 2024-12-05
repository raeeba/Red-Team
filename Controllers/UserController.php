<?php
// Include paths as before
$pathToUserlogin = __DIR__ . "/../Models/User.php";
$pathToController = __DIR__ . "/Controller.php";

if (file_exists($pathToUserlogin) && file_exists($pathToController)) {
    include_once $pathToUserlogin;
    include_once $pathToController;
} else {
    echo "One or more files not found:";
    var_dump(file_exists($pathToUserlogin), file_exists($pathToController));
    exit;
}

class UserController extends Controller {
    function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "login";
        $param = isset($_GET['param']) ? urldecode($_GET['param']) : null; // Get the parameter (email)

        if ($action == "login") {
            if ($this->isLoggedIn()) {
                header("Location: " . $this->getBasePath() . "/en/inventory/list");
                exit();
            }
            $this->render("Login", "login");
        } else if ($action == "verify") {
            if (isset($_POST['email'], $_POST['password'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
        
                $user = new User();
                $isValidLogin = $user->login($email, $password);
        
                if ($isValidLogin) {
                    session_start();
                    $_SESSION['email'] = $user->email;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['birthday'] = $user->birthday;
                    $_SESSION['role'] = $user->role;
                    $language = isset($_POST['language']) ? $_POST['language'] : 'en'; // Default to 'en'
            $_SESSION['language'] = $language;

                    $this->render("Login", "2FA", ['user' => $user]);
                } else {
                   
                    $data =   ['error'=>"Login Failed! Incorrect credentials."];
                    $this->render("Login", "login",$data);
                }
            } else {
                $data = "Please enter email and password.";
                $this->render("Login", "login", $data);
            }
        } else if($action == "forgot"){
            $this->render("Login", "Forgot");

            if (isset($_POST['email'])){
                $email = $_POST['email'];
                
                $user = new User();
                $isValidEmail = $user->forgot($email);
            }
            //header("Location: " . $this->getBasePath() . "/en/user/login");
            
        } else if ($action == "list") {
            $this->checkSession();

            if (!$this->verifyRights($_SESSION['email'], 'employee', $action)) {
                echo "Permission denied.";
                return false;
            }

            $user = User::list();
            $data = [
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'employees' => $user
            ];
            $this->render("Employee", "list", $data);
        } else if ($action == "modify" && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkSession();

          

            if (!$this->verifyRights($_SESSION['email'], 'employee', 'modify')) {
                echo "Permission denied.";
                return false;
            }
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;

           $user= User::getUserByEmail($email);

            if (!$user) {
                echo "User not found.";
                return false;
            }

            $data = [
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email'],
                'user' => $user
            ];
            $this->render("Employee", "modify", $data);
            
        } else if ($action == "validate_otp") {
            $this->checkSession();
            if (isset($_POST['otp'])) {
                $enteredOTP = $_POST['otp'];

                if (time() > $_SESSION['otp_expiration']) {
                    $data = "OTP has expired. Please request a new one.";
                    $this->render("Login", "login", ['error' => $data]);
                } elseif ($enteredOTP === $_SESSION['otp']) {
                    unset($_SESSION['otp']);
                    unset($_SESSION['otp_expiration']);
                    echo "2FA verification successful!";
                } else {
                    $data = "Invalid OTP. Please try again.";
                    $this->render("Login", "2FA", ['error' => $data]);
                }
            }
        }  else if ($action == "logout" ) {
            $this->checkSession();

        
            $_SESSION = array();
            session_destroy();
        
            header("Location: " . $this->getBasePath() . "/en/user/login");
            exit();
        }else if ($action == "updateSave" && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkSession();

        
            if (!$this->verifyRights($_SESSION['email'], 'employee', 'modify')) {
                echo "Permission denied.";
                return false;
            }
        
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            $name = isset($_POST['name']) ? trim($_POST['name']) : null;
            $birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : null;
            $role = isset($_POST['role']) ? trim($_POST['role']) : null;
        
            if (!$email || !$name || !$birthday || !$role) {
                echo "All fields are required.";
                return false;
            }
        
            $result = User::updateUserByEmail($email, $name, $birthday, $role);
        
            if ($result) {
                header("Location: " . $this->getBasePath() . "/en/user/list");
                exit();
            } else {
                echo "Error updating employee.";
            }
        }else if($action=="add"){
            $this->checkSession();

        
            if (!$this->verifyRights($_SESSION['email'], 'employee', 'modify')) {
                echo "Permission denied.";
                return false;
            }
            $data = [
                'name' => $_SESSION['name'],
                'email' => $_SESSION['email']
            ];
            $this->render("employee", "add",$data);

        } else if ($action == "addSave" && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkSession();

    
            $firstName = isset($_POST['first_name']) ? trim($_POST['first_name']) : null;
            $lastName = isset($_POST['last_name']) ? trim($_POST['last_name']) : null;
            $birthday = isset($_POST['birthday']) ? trim($_POST['birthday']) : null;
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            $password = isset($_POST['password']) ? trim($_POST['password']) : null;
            $role = isset($_POST['role']) ? trim($_POST['role']) : null;


    
            if (!$firstName || !$lastName || !$birthday || !$email || !$password || !$role) {
                echo "All fields are required.";
                return false;
            }
    

           $firstName=filter_var($firstName, FILTER_SANITIZE_STRING);
           $lastName=filter_var($lastName, FILTER_SANITIZE_STRING);
           $email=filter_var($email, FILTER_SANITIZE_STRING);
           $role=filter_var($role, FILTER_SANITIZE_STRING);

            $result = User::addNewUser($firstName, $lastName, $birthday, $email, $password, $role);
    
            if ($result) {
                header("Location: " . $this->getBasePath() . "/en/user/list");
                exit();
            } else {
                echo "Error adding employee.";
            }
        } else if($action="delete"&& $_SERVER['REQUEST_METHOD'] == 'POST'){
            $this->checkSession();

            if (!$this->verifyRights($_SESSION['email'], 'employee', 'delete')) {
                echo "Permission denied.";
                return false;
            }
        
            $selectedEmployees = isset($_POST['selected_employees']) ? $_POST['selected_employees'] : [];
        
            if (empty($selectedEmployees)) {
                echo "No employees selected for deletion.";
                return false;
            }
        
            $result = User::deleteUsersByEmails($selectedEmployees);
        
            if ($result) {
                header("Location: " . $this->getBasePath() . "/en/user/list");
                exit();
            } else {
                echo "Error deleting employees.";
            }
        }

        }
        }
    

