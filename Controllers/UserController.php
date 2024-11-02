<?php
// Include paths as before
$pathToUserlogin = __DIR__ . "/../Models/Userlogin.php";
$pathToController = __DIR__ . "/Controller.php";

if (file_exists($pathToUserlogin) && file_exists($pathToController)) {
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

        } if ($action == "verify") {
            echo "<pre>Debug: Verify action reached with POST data:</pre>";
            print_r($_POST);
        
            if (isset($_POST['email'], $_POST['password'])) {
                $email = trim($_POST['email']);
                $password = trim($_POST['password']);
        
                $user = new User();
                $isValidLogin = $user->login($email, $password);
        
                if ($isValidLogin) {
                    session_start();
                    $_SESSION['email'] = $user->email;
                    echo "Debug: user name is " . $user->name;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['birthday'] = $user->birthday;
                    $_SESSION['role'] = $user->role;
        
                    // Redirect to 2FA view if login is successful
                    echo "<pre>Debug: Login successful, rendering 2FA view...</pre>";
                    $this->render("Login", "2FA", ['user' => $user]);
                } else {
                    // Redirect to login with an error message
                    $data = "Login Failed! Incorrect credentials.";
                    $this->render("Login", "login", ['error' => $data]);
                }
            } else {
                // Redirect back to login with an error message if POST data is missing
                $data = "Please enter email and password.";
                $this->render("Login", "login", ['error' => $data]);
            }
        
        }else if($action== "list"){
            session_start();

            if (!$this->verifyRights($_SESSION['email'], 'inventory', $action)) {
                echo "Permission denied.";
                return false;
            }


            $user= User::list();
            

            $data=[
                'name'=>$_SESSION['name'],
                'email'=>$_SESSION['email'],
                'employees'=>$user
            ];
            $this->render("Employee","list",$data);
        }
        
        // else if($action=='modify'){
        //     session_start();
        //     if(!$this->verifyRights($_SESSION['email'], 'employee','modify')){
        //         echo "Permission denied please go back to inventory.";
        //         return false;
        //     }
        //     if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        //         // Get employee data for the given email
        //         $email = isset($_GET['email']) ? $_GET['email'] : null;
        //         if ($email) {
        //             $employeeModel = new Employee();
        //             $employee = $employeeModel->getEmployeeByEmail($email);
        //             if ($employee) {
        //                 $data = [
        //                     'name' => $_SESSION['name'],
        //                     'email' => $_SESSION['email'],
        //                     'employee' => $employee,
        //                 ];
        //                 $this->render("Employee", "modify", $data);
        //             } else {
        //                 echo "Employee not found.";
        //             }
        //         }
        //     } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        //         // Handle form submission for employee modification
        //         $employeeData = [
        //             'name' => $_POST['name'],
        //             'email' => $_POST['email'],
        //             'birthday' => $_POST['birthday'],
        //             'adminType' => $_POST['adminType'],
        //         ];
        //         $employeeModel = new Employee();
        //         $result = $employeeModel->updateEmployee($employeeData);
        
        //         if ($result) {
        //             header("Location: {$basePath}/employee/list");
        //             exit();
        //         } else {
        //             echo "Failed to update employee.";
        //         }
        //     }
        // }

    
              

        
        
        else if ($action == "validate_otp") {
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
    

