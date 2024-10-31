<?php
$pathToUserinfo = __DIR__ . "/../Models/Userinfo.php";
$pathToUserlogin = __DIR__ . "/../Models/Userlogin.php";
$pathToController = __DIR__ . "/Controller.php";

// Check if the files exist before including them
if (file_exists($pathToUserinfo) && file_exists($pathToUserlogin) && file_exists($pathToController)) {
    include_once $pathToUserinfo;
    include_once $pathToUserlogin;
    include_once $pathToController;
} else {
    echo "One or more files not found:";
    var_dump(file_exists($pathToUserinfo), file_exists($pathToUserlogin), file_exists($pathToController));
    var_dump($pathToUserinfo, $pathToUserlogin, $pathToController);
    exit; // Stop execution if files are not found
}

class UserController extends Controller {
    function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : "login";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

        if ($action == "login") {
            $this->render("Login", "login");
        } else if ($action == "verify") {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $user = new User();
                $isValidLogin = $user->login($_POST['email'], $_POST['password']);

                if ($isValidLogin) {
                    session_start();

                    $_SESSION['email'] = $user->email;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['birthday'] = $user->birthday;
                    $this->render("user", "2FA", $user);
                } else {
                    $data = LOGIN_FAILED . "!";
                    $this->render("user", "login", $data);
                }
            }
        } else if ($action == "forgot") {
            $this->render("user", "Forgot");
        }
    }
}
?>
