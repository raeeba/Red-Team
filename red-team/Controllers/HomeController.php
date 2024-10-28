<?php
include_once "Controllers/Controller.php";

class HomeController extends Controller{


    function route(){
        $this->render("Home","HomeView");
    }





}



?>