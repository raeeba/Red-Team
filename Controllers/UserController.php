<?php
$pathToUserinfo = realpath(__DIR__ . "/../Models/Userinfo.php");
$pathToUserlogin = realpath(__DIR__ . "/../Models/Userlogin.php");
$pathToController = realpath(__DIR__ . "/Controller.php");


if ($pathToUserinfo && $pathToUserlogin && $pathToController) {
    include_once $pathToUserinfo;
    include_once $pathToUserlogin;
    include_once $pathToController;
}

class UserController extends Controller{
	function route(){
		$action = isset($_GET['action']) ? $_GET['action'] : "login"   ;
		$id = isset($_GET['id']) ? intval($_GET['id']) : -1;

       
        if($action == "login"){//var_dump($_POST);
            if(isset($_POST['email']) && isset($_POST['password'])) {


                $user = new User();
                $isValidLogin = $user->login($_POST['email'], $_POST['password']);
                
                
                if($isValidLogin){

                    session_start();

                    $_SESSION['email'] = $user->email;
                    $_SESSION['name'] = $user->name;
                    $_SESSION['birthday'] = $user->birthday;
                    $this->render("user","2FA",$user);
                }
                else{
                    $data = LOGIN_FAILED . "!";
                    $this->render("user","Login", $data);
                   
                }
               
                    // show static login page
                    $this->render("User", );
                

            }
            }
            else if($action='forgot'){
                $this->render("user","Forgot");
            }
            else if($action= ""){
        
    
           
        
        
            }
	}
}

?>