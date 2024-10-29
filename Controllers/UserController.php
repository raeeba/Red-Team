<?php
include_once "Models/Userinfo.php";
include_once "Models/Userlogin.php";
include_once "Controllers/Controller.php";

class UserController extends Controller{
	function route(){
		$action = isset($_GET['action']) ? $_GET['action'] : "list"   ;
		$id = isset($_GET['id']) ? intval($_GET['id']) : -1;

       
        if($action == "login"){//var_dump($_POST);
            if(isset($_POST['email']) && isset($_POST['password'])) {

                // Validate the login against provided data
                $data = User::login($_POST);
                if($data > 0){
                    $this->render("home");
                }
                else{
                    $data = LOGIN_FAILED . "!";
                    $this->render("user","login", $data);
                   
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

?>