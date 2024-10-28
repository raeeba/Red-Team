<?php
include_once "Models/Order.php";
include_once "Controllers/Controller.php";



class OrderController extends Controller{

function route(){

    $action = isset($_GET['action']) ? $_GET['action'] : "OrderView";
    $id = isset($_GET['id']) ? intval($_GET['id']) : -1;

if($action=="defaultView"){
    $action= "OrderView";
    }

    echo "Action: " . $action . "<br>";
    echo "ID: " . $id . "<br>";

    if ($action == "OrderView") {
        $order = Order::list();
        $this->render("Order", "OrderView", $order);

}else if($action=="view"){
   $order=new Order($id);
   $orderDetail = Order::getDetails($id); 
   
   $this->render("Order", "view", ['order'=>array($order), 'orderDetails'=>$orderDetail]);



}else if($action=="update"){
  $order = new Order($id);
  $orderDetail = Order::getDetails($id); 
  $this->render("Order", "update", ['order'=>array($order), 'orderDetails'=>$orderDetail] );

}else if($action=="updateSave"){
    $order= new Order($id);
    $order->updateSave($_POST);
    header("location: /mvcpractice/order");

}else if($action=="delete"){
    $order= new Order($id);
    $order->delete($_POST);
    header("location: /mvcpractice/order");

}else if($action=="add"){
   

}
else if($action=="insert"){
  

}




}

}


?>