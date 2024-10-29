<?php
include_once "Models/Payment.php";
include_once "Controllers/Controller.php";

class PaymentController extends Controller{


function route(){


    $action = isset($_GET['action']) ? $_GET['action'] : "EmployeeView";
    $id = isset($_GET['id']) ? ($_GET['id']) : "";

    if($action=="defaultView"){
        $action= "PaymentView";
        }

        echo "Action: " . $action . "<br>";
        echo "ID: " . $id . "<br>";
    
        if ($action == "PaymentView") {
            $payment=Payment::list();
            $this->render("Payment", "PaymentView", $payment);
  
  
          }else if($action =="view"){
            $payment = new Payment($id);
            $this->render("Payment", "view", array($payment));
           

          }else if($action=="update"){

            $payment = new Payment($id);
            $this->render("Payment", "update", array($payment));

          }else if($action =="updateSave"){
            $payment= new Payment($id);
            $payment->save($_POST); 
            header("location: /mvcpractice/payment");


          }else if($action =="delete"){
            $payment = new Payment($id);
            $payment -> delete($id);
            header("location: /mvcpractice/payment");

        }

}








}