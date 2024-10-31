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
    function route($action = "login", $id = null) {
        if ($action == "login") {
            $this->render("Login", "login");

        } if ($action == "verify") {
            // Debugging to check $_POST data
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            $this->render("Login", "2FA");
        
            if (isset($_POST['email'], $_POST['password'], $_POST['role'])) {
                // Proceed with the login logic
                $email = $_POST['email'];
                $password = $_POST['password'];
                $role = $_POST['role'];
                
                $user = new User();
                $isValidLogin = $user->login($email, $password, $role);
        
                if ($isValidLogin) {
                    session_start();
                    $_SESSION['email'] = $user->email;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['birthday'] = $user->birthday;
                    $_SESSION['role'] = $user->role;
                    $_SESSION['group_id'] = $user->group_id;
        
                    // Redirect to 2FA view if login is successful
                    $this->render("Login", "2FA", ['user' => $user]);
                } else {
                    $data = "Login Failed! Incorrect credentials.";
                    $this->render("Login", "login", ['error' => $data]);
                }
            } else {
                // Redirect back to login with an error message if POST data is missing
                $data = "Please enter email and password.";
                $this->render("Login", "login", ['error' => $data]);
            }
        }
    }     
}

?>
