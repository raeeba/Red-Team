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
        $param = isset($_GET['param']) ? urldecode($_GET['param']) : null; 

        if ($action == "login") {
            if ($this->isLoggedIn()) {
                session_start();

                header("Location: " . $this->getBasePath() . "/" . $_SESSION['language'] . "/inventory/list");
                
                                exit();
            }
            $this->render("Login", "login");
            
        } 
        
        // verify user email and password to see if it is stored in the db
        else if ($action == "verify") {
            if (isset($_POST['email'], $_POST['password'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
        
                $user = new User();
                //calls the login method (if the login is good-> true)
                $isValidLogin = $user->login($email, $password);
            
                //if true
                if ($isValidLogin) {
                    $_SESSION['email'] = $user->email;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['birthday'] = $user->birthday;
                    $_SESSION['role'] = $user->role;
                    $language = isset($_POST['language']) ? $_POST['language'] : 'en'; // default to 'en'
                    $_SESSION['language'] = $language;

                    // send email with authentication code to user's email
                    $code = $user->sendAuthenticationCode($email);
                    $data =   [
                        'error'=>"",
                        'user' => $user
                    
                    ];

                    // render 2FA page if login info correct
                    $this->render("Login", "2FA", $data);
                }
            
                else { // render login page if login info incorrect
                    $data =   ['error'=>"Login Failed! Incorrect credentials."];
                    $this->render("Login", "login",$data);
                }
            } else { // render login page if no login info provided
                $data = "Please enter email and password.";
                $this->render("Login", "login", $data);
            }
        } 

        // 2FA
        else if ($action == "authentication"){ 
            // check session
            $this->checkSession();

            // verify users rights
            $hasAccess = $this->verifyRights($_SESSION['email'], "employee", 'authenticate');

            if (!$hasAccess) {
                echo "Permission denied.";
                return false;
            }
    
            if (isset($_POST['code'])){ 
                $code = $_POST['code'];
                $email = $_SESSION['email']; 

                $user = new User();
                $isAuthenticated = $user->isAuthenticated($email, $code);
                
                // if code entered matches code stored in db
                if ($isAuthenticated){ 
                    // redirect to inventory list
                    header("Location: " . $this->getBasePath() . "/" . $_SESSION['language']. "/inventory/list");
                    exit(); 

                } else { // if code does not match code in db
                    $data =   ['error'=>"Login failed! Code does not match."];
                    $this->render("Login", "2FA", $data);
                }
            }
        }
            
        // forgot password
        else if($action == "forgot"){
            $this->render("Login", "Forgot");

            if (isset($_POST['email'])){
                $email = $_POST['email'];
                
                $user = new User();
                $code = $user->sendResetPasswordLink($email); // send reset password link to provided email
            }
        } 

        // reset password
        else if ($action == "reset"){
            $this->render("Login", "reset");

            if (isset($_POST['code'], $_POST['password'], $_POST['confirmPassword'])){
                $code = $_POST['code'];
                $password = $_POST['password'];
                $confirmPassword = $_POST['confirmPassword'];

                $user = new User();
                $isPasswordReset = $user -> resetPassword($code, $password, $confirmPassword);

                if ($isPasswordReset){

                    // redirect to login page if password has been successfully changed
                    header("Location: " . $this->getBasePath() . "/" . $_SESSION['language']. "/user/login");
                    exit(); 
                } 

                else {
                    echo "Error. Information is incorrect.";
                }
            }
        }

        //action to see the employee list
        else if ($action == "list") {
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
            //checks if the action is modify and that the server request is post
        } else if ($action == "modify" && $_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->checkSession();

          

            if (!$this->verifyRights($_SESSION['email'], 'employee', 'modify')) {
                echo "Permission denied.";
                return false;
            }
            $email = isset($_POST['email']) ? trim($_POST['email']) : null;
            //checks the post data for the email

            //retrives the data from the user (based on the email found in the post)
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
            
            //if user logs out, destroy the session (for security)
        } else if ($action == "logout" ) {
            $this->checkSession();

        
            $_SESSION = array();
            session_destroy();
        
            $this->render("Login", "login");
            exit();

            
        } else if ($action == "updateSave" && $_SERVER['REQUEST_METHOD'] == 'POST') {
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
            //update the user with the new info
            $result = User::updateUserByEmail($email, $name, $birthday, $role);
        
            if ($result) {
                header("Location: " . $this->getBasePath() . "/" . $_SESSION['language']. "/user/list");
                exit();
            } else {
                echo "Error updating employee.";
            }


        } else if($action=="add"){
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
            //creates new user
            $result = User::addNewUser($firstName, $lastName, $birthday, $email, $password, $role);
    
            if ($result) {
                header("Location: " . $this->getBasePath() . "/" . $_SESSION['language'] . "/user/list");
                
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
                header("Location: " . $this->getBasePath() . "/"  . $_SESSION['language'] .  "/user/list");
                exit();
            } else {
                echo "Error deleting employees.";
            }
        }

        }
    }
    

