<?php
include_once "Models/Customer.php";
include_once "Controllers/Controller.php";



class CustomerController extends Controller{

function route(){

    $action = isset($_GET['action']) ? $_GET['action'] : "CustomerView";
    $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

if($action=="defaultView"){
    $action= "CustomerView";
    }

    echo "Action: " . $action . "<br>";
    echo "ID: " . $id . "<br>";

    if ($action == "CustomerView") {
        $customers = Customer::list();
        $this->render("Customer", "CustomerView", $customers);

}else if($action=="view"){
    $customer= new Customer($id);
    $this->render("Customer","view", array($customer));
}else if($action=="update"){
    $customer= new Customer($id);
    $this->render("Customer","update", array($customer));

}else if($action=="updateSave"){
    $customer= new Customer($id);
    $customer->updateSave($_POST);
    header("location: /mvcpractice/customer");

}else if($action=="delete"){
    $customer= new Customer($id);
    $customer->delete($_POST);
    header("location: /mvcpractice/customer");

}else if($action=="add"){
    $customerRep=Customer::getEmployee();

    $this->render("Customer","add", ['salesReparr'=> $customerRep]);

}
else if($action=="insert"){
   $customer= new Customer();
   $customer->insert($_POST);
   header("location: /mvcpractice/customer");

}




}

}


?>