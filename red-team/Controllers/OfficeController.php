<?php
include_once "Models/Office.php";
include_once "Controllers/Controller.php";


class OfficeController extends Controller{

function route(){
   
        $action = isset($_GET['action']) ? $_GET['action'] : "OfficeView";
        $id = isset($_GET['id']) ? intval($_GET['id']) : -1;
    
    if($action=="defaultView"){
        $action= "OfficeView";
        }

        echo "Action: " . $action . "<br>";
        echo "ID: " . $id . "<br>";
    
        if ($action == "OfficeView") {
            $offices = Office::list();
            $this->render("Office", "OfficeView", $offices);
        }else if($action=="view"){
            $office=new Office($id);
            $this->render("Office","view",array($office));
        }else if($action=="update"){
            $office=new Office($id);
            $this->render("Office","update",array($office));
        }else if($action=="updateSave"){
            $office=new Office($id);
            $office->updateSave($_POST);
            header("location: /mvcpractice/office");
        }else if($action=="delete"){
            $office=new Office($id);
            $office->delete($id);
            header("location: /mvcpractice/office");

        }else if($action=="add"){
            if(!empty($_POST)){

                $office=new Office();
                $office->insert($_POST);
                header("location: /mvcpractice/office");
            }else{
                $this->render("Office","add");

            }

       
    }
    


}


}


?>