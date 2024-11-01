<?php
// Include paths as before
$pathToUserinfo = __DIR__ . "/../Models/Userinfo.php";
$pathToUserlogin = __DIR__ . "/../Models/Userlogin.php";
$pathToController = __DIR__ . "/Controller.php";

if (file_exists($pathToUserinfo) && file_exists($pathToUserlogin) && file_exists($pathToController)) {
    include_once $pathToUserinfo;
    include_once $pathToUserlogin;
    include_once $pathToController;
} else {
    echo "One or more files not found:";
    var_dump(file_exists($pathToUserinfo), file_exists($pathToUserlogin), file_exists($pathToController));
    exit;
}
class UserController extends Controller {
    function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "login";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;


        if ($action == "login") {
            // Render login page directly
          
            if ($this->isLoggedIn()) {
                // If logged in, redirect to the inventory page
                header("Location: " . $this->getBasePath() . "/en/inventory/list");
                exit();
            }
            $this->render("Login", "login");

        } else if ($action == "verify") {
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
        
            if (isset($_POST['email'], $_POST['password'], $_POST['role'])) {
                // Proceed with the login logic
                $email = $_POST['email'];
                $password = $_POST['password'];
                $role = trim($_POST['role']); // Normalize user input by trimming any extra whitespace
        
                $user = new User();
                $isValidLogin = $user->login($email, $password, $role);
        
                if ($isValidLogin) {
                    // Check if role is set and normalize it
                    $actualRole = isset($user->role) ? trim($user->role) : '';
        
                    // Debug print both roles to see if they match
                    echo "Debug: Provided role - '$role', Actual role from DB - '$actualRole'";
        
                    // Check if the provided role matches the actual role
                    if (strcasecmp($actualRole, $role) !== 0) {
                        // If roles do not match, redirect with an error message
                        $errorMessage = "Login Failed! Incorrect role selected.";
                        $this->render("Login", "login", ['error' => $errorMessage]);
                        return;
                    }
        
                    // If role matches, proceed to 2FA
                    session_start();
                    $_SESSION['email'] = $user->email;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['birthday'] = $user->birthday;
                    $_SESSION['role'] = $user->role;
                    $_SESSION['group_id'] = $user->group_id;
        
                    // Redirect to 2FA view if login is successful
                    $this->render("Login", "2FA", ['user' => $user]);
                } else {
                    // Redirect to login with an error message
                    $errorMessage = "Login Failed! Incorrect credentials.";
                    $this->render("Login", "login", ['error' => $errorMessage]);
                }
            } else {
                // Redirect back to login with an error message if POST data is missing
                $errorMessage = "Please enter email and password.";
                $this->render("Login", "login", ['error' => $errorMessage]);
            }
        }else if ($action == "validate_otp") {
            // Validate OTP
            session_start();
            if (isset($_POST['otp'])) {
                $enteredOTP = $_POST['otp'];

                if (time() > $_SESSION['otp_expiration']) {
                    $data = "OTP has expired. Please request a new one.";
                    $this->render("Login", "login", ['error' => $data]);
                } elseif ($enteredOTP === $_SESSION['otp']) {
                    unset($_SESSION['otp']);
                    unset($_SESSION['otp_expiration']);
                    echo "2FA verification successful!";
                    // Redirect to the user's dashboard or home page after successful 2FA
                } else {
                    $data = "Invalid OTP. Please try again.";
                    $this->render("Login", "2FA", ['error' => $data]);
                }
            }

        } else if($action=="logout") {
            // Default: load login page
            session_start();
            $_SESSION = array();
            session_destroy();
            header("Location: " . $this->getBasePath() . "/en/user/login");
            exit();
        }
    }
        }
    

